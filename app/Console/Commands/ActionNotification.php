<?php

namespace App\Console\Commands;

use App\Models\NotificationCustomer;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\Notification;
use App\Constants\NotificationConstant;

class  ActionNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:action';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i');
        $after = Carbon::now('Asia/Ho_Chi_Minh')->addMinutes(30)->format('Y-m-d H:i');

        Notification::where('status', NotificationConstant::HIDDEN)
            ->whereBetween('created_at', [$now, $after])
            ->update(['status' => NotificationConstant::UNREAD]);
        try {
            $data = NotificationCustomer::where('status', NotificationConstant::HIDDEN)
                ->whereBetween('created_at', [$now, $after])->with('customer')->get();
            if (count($data)) {
                foreach ($data as $item) {
                    if (isset($item->customer) && $item->customer->devices_token) {
                        fcmSendCloudMessage([$item->customer->devices_token], $item->title, 'Chạm để xem', 'notification',
                            (array)\GuzzleHttp\json_decode($item->data));
                    }
                }
            }

        } catch (\Exception $exception) {
            return $exception;
        }

    }
}
