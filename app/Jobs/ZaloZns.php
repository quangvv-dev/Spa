<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ZaloZns implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $phone;
    public $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($phone, $data)
    {
        $this->phone = $phone;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (empty(config('partners.zalo_zns.template_id'))) {
            return false;
        }
        $newPhone = substr_replace($this->phone, "84", 0, 1);
        $response = GuzzleHttpCall(config('partners.zalo_zns.url'), 'post',
            ['access_token' => config('partners.zalo_zns.access_token')]
            , ['tracking_id' => 'development', 'phone' => $newPhone, 'template_id' => config('partners.zalo_zns.template_id')
                , 'template_data' => $this->data]);
        if ($response->error == 0) {
            return true;
        } else {
            return false;
        }
    }
}
