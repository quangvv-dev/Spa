<?php

namespace App\Console\Commands;

use App\Services\TaskService;
use Illuminate\Console\Command;

class UpdateStatusTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:status_task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    private $taskService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(TaskService $taskService)
    {
        parent::__construct();
        $this->taskService = $taskService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $tasks = $this->taskService->updateStatus();
        $this->info('Update task status success!');
    }
}
