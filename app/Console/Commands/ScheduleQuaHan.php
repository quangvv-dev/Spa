<?php

namespace App\Console\Commands;

use App\Constants\DepartmentConstant;
use App\Constants\NotificationConstant;
use App\Constants\ScheduleConstant;
use App\Models\Schedule;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ScheduleQuaHan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:schedules_quahan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $schedules = Schedule::select('branch_id', \DB::raw('COUNT(id) as count'))->where('status', ScheduleConstant::QUA_HAN)
            ->where('date', Carbon::yesterday()->format('Y-m-d'))->groupBy('branch_id')->get();
        if (count($schedules)) {
            foreach ($schedules as $item) {
                $user = User::select('devices_token')->where('branch_id', $item->branch_id)->where('department_id', DepartmentConstant::BAN_GIAM_DOC)->first();
                if (!empty($user)){
                    fcmSendCloudMessage($user->devices_token, '⚠️ Có' . $item->count . ' lịch hẹn quá hạn hôm qua', 'Chạm để xem',
                        'notification', ['type' => NotificationConstant::SCHEDULE_QUA_HAN]);
                }
            }
        }
        $this->info('Update task status success!');
    }
}
