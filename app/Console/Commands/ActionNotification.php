<?php

namespace App\Console\Commands;

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
        Notification::where('status', NotificationConstant::HIDDEN)->where('created_at', $now)
            ->update(['status' => NotificationConstant::UNREAD]);
    }
}
