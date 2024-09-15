<?php

namespace App\Console\Commands;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Services\FirebaseService;
use Illuminate\Support\Facades\DB;

class  FireBaseNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:firebase';

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
    public function handle(FirebaseService $firebaseService)
    {
        //Xóa toàn bộ notification ngày hôm trước
        $firebaseService->removeChildren('notification');

        $tasks = Task::select('user_id', DB::raw('COUNT(id) as count'))->where('task_status_id', 1)->where('date_from',
            now()->format('Y-m-d'))->groupBy('user_id')->get();
        if (count($tasks)) {
            foreach ($tasks as $task) {
                $data = [
                    'title' => 'Hôm nay bạn có ' . $task->count . ' công việc CSKH',
                    'url'   => url('tasks-employee'),
                ];
                $firebaseService->setupReference('notification/' . $task->user_id, $data);
            }
        }
    }
}
