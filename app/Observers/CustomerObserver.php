<?php

namespace App\Observers;

use App\Constants\DepartmentConstant;
use App\Constants\NotificationConstant;
use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\Helpers\Functions;
use App\Models\Customer;
use App\Models\HistorySms;
use App\Models\HistoryStatus;
use App\Models\Notification;
use App\Models\RuleOutput;
use App\Models\SchedulesSms;
use App\Models\Status;
use App\Services\FirebaseService;
use App\Services\TaskService;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CustomerObserver
{
    private $taskService;

    public function __construct(TaskService $taskService, FirebaseService $firebaseService)
    {
        $this->taskService = $taskService;
        $this->firebase = $firebaseService;
    }

    /**
     * Handle the call center "created" event.
     *
     * @param App\Models\Customer $callCenter
     *
     * @return void
     */
    public function created(Customer $customer)
    {
        if (empty($customer->account_code)) {
            $customer_id = $customer->id < 10 ? '0' . $customer->id : $customer->id;
            $customer->account_code = 'KH' . $customer_id;
            $customer->save();
        }

        $customer->historyStatus()->create([
            'customer_id' => $customer->id,
            'status_id'   => $customer->status_id,
            'created_at'  => now(),
        ]);

        $customer->groupComments()->create([
            'customer_id' => $customer->id,
            'branch_id'   => $customer->branch_id,
            'status_id'   => $customer->status_id,
            'user_id'     => Auth::user()->id,
            'messages'    => "<span class='bold text-azure'>Tạo mới KH: </span> " . Auth::user()->full_name . " thao tác lúc " . date('H:i d-m-Y'),
        ]);
    }

    public function updated(Customer $customer)
    {
        if (empty($customer->account_code)) {
            $customer_id = $customer->id < 10 ? '0' . $customer->id : $customer->id;
            $customer->account_code = 'KH' . $customer_id;
            $customer->save();
        }
        $changedAttributes = $customer->getDirty();
        $oldData = $customer->getOriginal();

        // Kiểm tra sự thay đổi của các trường khác
        if (count($changedAttributes)) {
            $text = '';
            if (!empty(@$changedAttributes['mkt_id']) && !empty(@$oldData['mkt_id'])) {
                $text = $text . ' <span class="text-purple">MKT: ' . @User::find($oldData['mkt_id'])->full_name . ' --> ' . @User::find($changedAttributes['mkt_id'])->full_name . '</span>';
            }
            if (!empty(@$changedAttributes['telesales_id']) && !empty(@$oldData['telesales_id'])) {
                $text = $text . ' <span class="text-info">| Sale: ' . @User::find($oldData['telesales_id'])->full_name . ' --> ' . @User::find($changedAttributes['telesales_id'])->full_name . '</span>';
            }
            if (!empty(@$changedAttributes['status_id']) && !empty(@$oldData['status_id'])) {
                $text = $text . ' <span class="text-green">| Trạng thái: ' . @Status::find($oldData['status_id'])->name . ' --> ' . @Status::find($changedAttributes['status_id'])->name . '</span>';
                $oldStatus = HistoryStatus::where('status_id', $oldData['status_id'])->first();
                if (!empty($oldStatus)) {
                    $oldStatus->updated_at = now();
                    $oldStatus->save();
                }
                $customer->historyStatus()->create([
                    'customer_id' => $customer->id,
                    'status_id'   => $changedAttributes['status_id'],
                    'created_at'  => now(),
                ]);
            }
            if (!empty($text)) {
                $customer->groupComments()->create([
                    'customer_id' => $customer->id,
                    'branch_id'   => $customer->branch_id,
                    'status_id'   => $customer->status_id,
                    'user_id'     => Auth::user()->id,
                    'messages'    => "<span class='bold text-danger'>Chỉnh sửa thông tin: </span> " . $text,
                ]);
            }
            if (!empty(@$changedAttributes['status_id']) && !empty(@$oldData['status_id'])) {
                $check2 = RuleOutput::where('event', 'change_relation')->first();
                if (isset($check2) && $check2) {
                    $rule = $check2->rules;
                    $config = @json_decode(json_decode($rule->configs))->nodeDataArray;
                    $rule_status = Functions::checkRuleStatusCustomer($config);
                    foreach (array_values($rule_status) as $k1 => $item) {
                        $list_status = $item->configs->group;
                        if (in_array($customer->status_id, $list_status)) {
                            // Tạo công việc
                            $jobs = Functions::checkRuleJob($config);

                            if (count($jobs)) {
                                foreach ($jobs as $job) {
                                    if (isset($job->configs->type_job) && @$job->configs->type_job == 'cskh') {
                                        $user_id = !empty($customer->cskh_id) ? $customer->cskh_id : $customer->telesales_id;
                                        $rule->position = 0;
                                        $rule->save();
                                        $type = StatusCode::CSKH;
                                        $prefix = "CSKH ";

                                    } else {
                                        $user_id = @$customer->telesales_id;
                                        $type = StatusCode::GOI_LAI;
                                        $prefix = "Gọi lại ";
                                    }

                                    $day = $job->configs->delay_value;
                                    $delay_unit = $job->configs->delay_unit;
                                    $sms_content = $job->configs->sms_content;
                                    $category = @$customer->categories;
                                    $text_category = [];
                                    if (count($category)) {
                                        foreach ($category as $item) {
                                            $text_category[] = $item->name;
                                        }
                                    }
                                    $text_order = "Ngày chuyển trạng thái : " . $customer->updated_at;
                                    $input = [
                                        'customer_id'     => @$customer->id,
                                        'date_from'       => $delay_unit == 'hours' ? Carbon::now()->addHours($day)->format('Y-m-d') : Carbon::now()->addDays($day)->format('Y-m-d'),
                                        'time_from'       => '07:00',
                                        'time_to'         => '21:00',
                                        'code'            => 'CSKH',
                                        'user_id'         => $user_id,
                                        'all_day'         => 'on',
                                        'priority'        => 1,
                                        'branch_id'       => @$customer->branch_id,
                                        'customer_status' => @$customer->status_id,
                                        'type'            => $type,
                                        'sms_content'     => Functions::vi_to_en($sms_content),
                                        'name'            => $prefix . @$customer->full_name . ' - ' . @$customer->phone . ' - nhóm ' . implode(",",
                                                $text_category) . ' ,' . @$customer->branch->name,
                                        'description'     => $text_order . "--" . replaceVariable($sms_content,
                                                @$customer->full_name, @$customer->phone,
                                                @$customer->branch->name, @$customer->branch->phone,
                                                @$customer->branch->address),
                                    ];

                                    $task = $this->taskService->create($input);
                                    $follow = User::where('department_id',
                                        DepartmentConstant::ADMIN)->orWhere(function ($query) {
                                        $query->where('department_id',
                                            DepartmentConstant::TELESALES)->where('is_leader',
                                            UserConstant::IS_LEADER);
                                    })->where('active', StatusCode::ON)->get();
                                    $task->users()->attach($follow);
                                    $title = $task->type == NotificationConstant::CALL ? '💬💬💬 Bạn có công việc gọi điện mới !'
                                        : '📅📅📅 Bạn có công việc chăm sóc mới !';
                                    Notification::insert([
                                        'title'      => $title,
                                        'user_id'    => $task->user_id,
                                        'type'       => $task->type,
                                        'task_id'    => $task->id,
                                        'status'     => NotificationConstant::HIDDEN,
                                        'created_at' => $task->date_from . ' ' . $task->time_from,
                                        'data'       => json_encode((array)['task_id' => $task->id]),
                                    ]);
                                }
                            }
                            // end cong viec

                        }
                    }
                }
            }
            if (!empty(@$changedAttributes['cskh_id'])) {
                $data = [
                    'title' => 'Bạn được phân bổ CSKH (' . $customer->account_code . ')',
                    'url'   => route('customers.show', $customer->id),
                ];
                $this->firebase->setupReference('notification/' . $customer->cskh_id, $data);
            }
            if (!empty(@$changedAttributes['telesales_id'])) {
                $data = [
                    'title' => 'Khách hàng (' . $customer->account_code . ') được phân bổ cho bạn',
                    'url'   => route('customers.show', $customer->id),
                ];
                $this->firebase->setupReference('notification/' . $customer->telesales_id, $data);
            }
        }
    }
}
