<?php

namespace App\Observers;

use App\Constants\DepartmentConstant;
use App\Constants\NotificationConstant;
use App\Constants\StatusCode;
use App\Constants\UserConstant;
use App\Helpers\Functions;
use App\Jobs\ZaloZns;
use App\Models\HistorySms;
use App\Models\Notification;
use App\Models\PaymentHistory;
use App\Models\RuleOutput;
use App\Models\Schedule;
use App\Services\TaskService;
use App\Services\ZaloService;
use App\User;
use Carbon\Carbon;

class ScheduleObserver
{

    public function __construct(TaskService $taskService, ZaloService $zalo)
    {
        $this->taskService = $taskService;
        $this->zalo = $zalo;
    }

    /**
     * @param Schedule $schedule
     * @return void
     */
    public function created(Schedule $schedule)
    {
        if (!empty(setting('template_schedule_id'))) {
            $input = $this->zalo->compareDataSchedule($schedule);
            ZaloZns::dispatch(@$schedule->customer->phone, $input, setting('template_schedule_id'))->delay(now()->addSeconds(5));
        }
        self::automationJob($schedule);
    }

    /**
     * Handle the schedule "updated" event.
     *
     * @param Schedule $schedule
     * @return void
     */
    public function updated(Schedule $schedule)
    {
        $originalData = $schedule->getOriginal();

        foreach ($originalData as $field => $value) {
            if ($schedule->isDirty($field)) {
                if ($field == 'status') {
                    self::automationJob($schedule);
                }
            }
        }
    }

    /**
     * Handle the schedule "deleted" event.
     *
     * @param Schedule $schedule
     * @return void
     */
    public function deleted(Schedule $schedule)
    {
        //
    }

    /**
     * Handle the schedule "restored" event.
     *
     * @param Schedule $schedule
     * @return void
     */
    public function restored(Schedule $schedule)
    {
        //
    }

    /**
     * Handle the schedule "force deleted" event.
     *
     * @param \App\Schedule $schedule
     * @return void
     */
    public function forceDeleted(Schedule $schedule)
    {
        //
    }

    public function automationJob($schedule)
    {
        $check2 = RuleOutput::where('event', 'add_schedule')->groupBy('rule_id')->get();
        if ($check2) {
            foreach ($check2 as $item) {
                if (@$item->rules->status == StatusCode::ON) {
                    $rule = $item->rules;
                    $status = $rule->ruleOutput->pluck('actor')->toArray();
                    if (!in_array($schedule->status, $status)) {
                        return false;
                    }
                    $config = @json_decode(json_decode($rule->configs))->nodeDataArray;
                    $jobs = Functions::checkRuleJob($config);
                    if (count($jobs)) { //add thêm role type
                        foreach ($jobs as $job) {
                            if ($job->configs->type_job && @$job->configs->type_job == 'cskh') {
                                $type = StatusCode::CSKH;
                            } else {
                                $type = StatusCode::GOI_LAI;
                            }
                            $prefix = 'Nhắc lịch hẹn trạng thái ' . $schedule->name_status;
                            $exactly_value = Functions::getExactlyTime($job);
                            $sms_content = $job->configs->sms_content;
                            $input = [
                                'customer_id' => @$schedule->user_id,
                                'date_from' => $exactly_value,
                                'time_from' => '07:00',
                                'time_to' => '21:00',
                                'code' => $prefix,
                                'user_id' => @$schedule->person_action,
                                'all_day' => 'on',
                                'priority' => 1,
                                'branch_id' => @$schedule->branch_id,
                                'type' => $type,
                                'sms_content' => Functions::vi_to_en($sms_content),
                                'name' => $prefix . ' ' . @$schedule->customer->full_name . ' - ' . @$schedule->customer->phone . ' ,' . @$schedule->branch->name,
                                'description' => replaceVariable($sms_content,
                                    @$schedule->customer->full_name, @$schedule->customer->phone,
                                    @$schedule->branch->name, @$schedule->branch->phone,
                                    @$schedule->branch->address),
                            ];

                            $task = $this->taskService->create($input);
                            $follow = User::where('department_id', DepartmentConstant::ADMIN)->orWhere(function ($query) {
                                $query->where('department_id', DepartmentConstant::TELESALES)->where('is_leader',
                                    UserConstant::IS_LEADER);
                            })->where('active', StatusCode::ON)->get();
                            $task->users()->attach($follow);
//                            $title = $task->type == StatusCode::GOI_LAI ? '💬💬💬 Bạn có công việc gọi điện mới !'
//                                : '📅📅📅 Bạn có công việc chăm sóc mới !';
//                            Notification::insert([
//                                'title' => $title,
//                                'user_id' => $task->user_id,
//                                'type' => $task->type,
//                                'task_id' => $task->id,
//                                'status' => NotificationConstant::HIDDEN,
//                                'created_at' => $task->date_from . ' ' . $task->time_from,
//                                'data' => json_encode((array)['task_id' => $task->id]),
//                            ]);
                        }
                    }
                }
            }
        }
    }
}
