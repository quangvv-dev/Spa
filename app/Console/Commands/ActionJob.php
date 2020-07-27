<?php

namespace App\Console\Commands;

use App\Helpers\Functions;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\HistorySms;

class  ActionJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job:action';

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
        $yesterday = Carbon::yesterday('Asia/Ho_Chi_Minh')->format('Y-m-d');
        Task::where('date_from', $yesterday)->with('customer', 'user')->where('task_status_id', 1)
            ->update(['task_status_id' => 6]);
//        if (count($task)) {
//            foreach ($task as $item) {
//                $err = Functions::sendSmsV3(@$item->customer->phone, @$item->sms_content);
//                if (isset($err) && $err) {
//                    $input['phone'] = @$item->customer->phone;
//                    $input['campaign_id'] = 0;
//                    $input['message'] = @$item->sms_content;
//                    HistorySms::create($input);
//                }
//            }
//        }
    }
}
