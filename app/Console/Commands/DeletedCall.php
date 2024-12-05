<?php

namespace App\Console\Commands;

use App\Models\CallCenter;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Console\Command;

class  DeletedCall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deleted:Call';

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
        $date = Carbon::now('Asia/Ho_Chi_Minh')->subMonths('3')->format('Y-m-d');
        CallCenter::whereDate('start_time','<',$date)->delete();
    }
}
