<?php

namespace App\Console\Commands\Zalo;

use App\Services\ZaloService;
use Illuminate\Console\Command;

class SaveToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:save-zalo-token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $zaloService;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(ZaloService $zaloService)
    {
        $zaloService->saveTokenZalo();
        return 1;
    }
}
