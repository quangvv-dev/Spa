<?php

namespace App\Jobs;

use App\Models\TokenZalOa;
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
     * @param $phone
     * @param $data
     */
    public function __construct($phone, $data)
    {
        $this->phone = $phone;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return bool
     */
    public function handle()
    {
        $oa = TokenZalOa::first();
        if (empty(config('partners.zalo_zns.template_id')) || empty($oa)) {
            return false;
        }
        $newPhone = substr_replace($this->phone, "84", 0, 1);
        $response = GuzzleHttpCall(config('partners.zalo_zns.url'), 'post',
            ['access_token' => $oa->access_token]
            , [
                'tracking_id'   => 'development',
                'phone'         => $newPhone,
                'template_id'   => config('partners.zalo_zns.template_id'),
                'template_data' => $this->data,
            ]);
        if ($response->error == 0) {
            return true;
        } else {
            return false;
        }
    }
}
