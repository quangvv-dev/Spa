<?php

namespace App\Observers;

use App\Constants\DepartmentConstant;
use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\Helpers\Functions;
use App\Models\Customer;
use App\Models\HistoryStatus;
use App\Models\RuleOutput;
use App\Models\Status;
use App\Services\TaskService;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CustomerObserver
{
    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
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
        dd([
            'customer_id' => $customer->id,
            'branch_id'   => $customer->branch_id,
            'status_id'   => $customer->status_id,
            'user_id'     => Auth::user()->id ?? $customer->carepage_id,
            'messages'    => "<span class='bold text-azure'>Tạo mới KH: </span> " . Auth::user()->full_name??User::find($customer->carepage_id)->full_name . " thao tác lúc " . date('H:i d-m-Y'),
        ]);
        if (!empty($customer->facebook)) {
            $this->actionJobsCreatedCustomer($customer);
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
            'user_id'     => Auth::user()->id ?? $customer->carepage_id,
            'messages'    => "<span class='bold text-azure'>Tạo mới KH: </span> " . Auth::user()->full_name??User::find($customer->carepage_id)->full_name . " thao tác lúc " . date('H:i d-m-Y'),
        ]);
    }

    public function updated(Customer $customer)
    {
        $changedAttributes = $customer->getDirty();
        $oldData = $customer->getOriginal();
        // Kiểm tra sự thay đổi của các trường khác
        if (count($changedAttributes)) {
            $text = '';
            if (!empty(@$changedAttributes['mkt_id']) && !empty(@$oldData['mkt_id'])) {
                $text = $text . ' <span class="text-purple">MKT: ' . User::find($oldData['mkt_id'])->full_name . ' --> ' . User::find($changedAttributes['mkt_id'])->full_name . '</span>';
            }
            if (!empty(@$changedAttributes['telesales_id']) && !empty(@$oldData['telesales_id'])) {
                $text = $text . ' <span class="text-info">| Sale: ' . User::find($oldData['telesales_id'])->full_name . ' --> ' . User::find($changedAttributes['telesales_id'])->full_name . '</span>';
            }
            if (!empty(@$changedAttributes['status_id']) && !empty(@$oldData['status_id'])) {
                $text = $text . ' <span class="text-green">| Trạng thái: ' . Status::find($oldData['status_id'])->name . ' --> ' . Status::find($changedAttributes['status_id'])->name . '</span>';
                $oldStatus = HistoryStatus::where('status_id', $oldData['status_id'])->first();
                $newStatus = HistoryStatus::where('status_id', $changedAttributes['status_id'])->first();
                if (!empty($oldStatus)) {
                    $oldStatus->updated_at = now();
                    $oldStatus->save();
                }
                if (!empty($newStatus)) {
                    $customer->historyStatus()->create([
                        'customer_id' => $customer->id,
                        'status_id'   => $customer->status_id,
                        'created_at'  => now(),
                    ]);
                }
                $abc = $this->actionJobChangeStatus($customer);
            }
            if (!empty($text)) {
                $customer->groupComments()->create([
                    'customer_id' => $customer->id,
                    'branch_id'   => $customer->branch_id,
                    'status_id'   => $customer->status_id,
                    'user_id'     => Auth::user()->id ?? $customer->carepage_id,
                    'messages'    => "<span class='bold text-danger'>Chỉnh sửa thông tin: </span> " . $text,
                ]);
            }
        }
    }

    protected function actionJobsCreatedCustomer($customer)
    {
        $output = RuleOutput::where('event', 'create_customer')
            ->whereHas('rules', function ($q) {
                $q->where('status', StatusCode::ON);
            })->first();
        $rule = $output->rules;
        $config = @json_decode(json_decode($rule->configs))->nodeDataArray;
        $jobs = Functions::checkRuleJob($config);

        if (count($jobs)) {
            foreach ($jobs as $job) {
                if (isset($job->configs->type_job) && @$job->configs->type_job == 'carepage') {
                    $user_id = !empty($customer->carepage_id) ? $customer->carepage_id : 0;
                    $rule->position = 0;
                    $rule->save();
                    $type = StatusCode::GOI_LAI;
                    $prefix = "Carepage tư vấn FB";
                }

                $day = $job->configs->delay_value;
                $delay_unit = $job->configs->delay_unit;
                $sms_content = $job->configs->sms_content;
                $input = [
                    'customer_id'     => @$customer->id,
                    'date_from'       => $delay_unit == 'hours' ? Carbon::now()->addHours($day)->format('Y-m-d') : Carbon::now()->addDays($day)->format('Y-m-d'),
                    'time_from'       => '07:00',
                    'time_to'         => '21:00',
                    'code'            => 'Carepage tư vấn qua FB',
                    'user_id'         => $user_id,
                    'all_day'         => 'on',
                    'priority'        => 1,
                    'branch_id'       => @$customer->branch_id,
                    'customer_status' => @$customer->status_id,
                    'type'            => $type,
                    'sms_content'     => Functions::vi_to_en($sms_content),
                    'name'            => $prefix . @$customer->full_name . ' - ' . @$customer->account_code . @$customer->branch->name,
                    'description'     => replaceVariable($sms_content,
                        @$customer->full_name, @$customer->phone,
                        @$customer->branch->name, @$customer->branch->phone,
                        @$customer->branch->address),
                ];

                $task = $this->taskService->create($input);
                $follow = User::where('department_id', DepartmentConstant::ADMIN)->orWhere(function ($query) {
                    $query->where('department_id', DepartmentConstant::CARE_PAGE)->where('is_leader',
                        UserConstant::IS_LEADER);
                })->where('active', StatusCode::ON)->get();
                $task->users()->attach($follow);
            }
        }
    }

    public function actionJobChangeStatus($customer)
    {
        $check2 = RuleOutput::where('event', 'change_relation')
            ->whereHas('rules', function ($q) {
                $q->where('status', StatusCode::ON);
            })->first();
        $rule = $check2->rules;
        $config = @json_decode(json_decode($rule->configs))->nodeDataArray;
        $jobs = Functions::checkRuleJob($config);
        $status = array_values(Functions::checkRuleStatusCustomer($config));
        $accessStatus = $status[0]->configs->group ?? [];
        if (count($jobs) && in_array($customer->status_id, $accessStatus)) {
            foreach ($jobs as $job) {
                if (isset($job->configs->type_job) && @$job->configs->type_job == 'cskh') {
                    $user_id = !empty($customer->cskh_id) ? $customer->cskh_id : 0;
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
                $text_order = $prefix . " KH " . @$customer->status->name;
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
                $follow = User::where('department_id', DepartmentConstant::ADMIN)->orWhere(function ($query) {
                    $query->where('department_id', DepartmentConstant::TELESALES)->where('is_leader',
                        UserConstant::IS_LEADER);
                })->where('active', StatusCode::ON)->get();
                $task->users()->attach($follow);
            }
        }
    }
}
