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
    public $template_id;

    /**
     * Create a new job instance.
     * @param $phone
     * @param $data
     */
    public function __construct($phone, $data, $template_id = null)
    {
        $this->phone = $phone;
        $this->data = $data;
        $this->template_id = $template_id ?? config('partners.zalo_zns.template_id');
    }

    /**
     * Execute the job.
     *
     * @return bool
     */
    public function handle()
    {
        $oa = TokenZalOa::first();
        if (empty($this->template_id) || empty($oa)) {
            return false;
        }
        $newPhone = substr_replace($this->phone, "84", 0, 1);
        $response = GuzzleHttpCall(config('partners.zalo_zns.url'), 'post',
            ['access_token' => $oa->access_token]
            , [
                'tracking_id' => 'development',
                'phone' => $newPhone,
                'template_id' => $this->template_id,
                'template_data' => $this->data,
            ]);
        return $response->error;
    }
}
