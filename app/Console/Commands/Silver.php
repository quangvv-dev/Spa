<?php

namespace App\Console\Commands;

use App\Helpers\Functions;
use App\Models\CustomerGroup;
use App\Models\Status;
use Illuminate\Console\Command;
use App\Models\Customer;
use App\Models\Order;

class  Silver extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job:silver';

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
        $data = [
            'to' => '0975091435',
            'from' => "ROYAL SPA",
            'message' => 'Test tin he thong',
            'scheduled' => "",//15-01-2019 16:05
            'requestId' => "",
            'useUnicode' => 0,//sử dụng có dấu hay k dấu
            'type' => 1 // CSKH hay QC
        ];
        $data = json_encode((object)$data);
        $base_url = 'http://api.brandsms.vn:8018/api/SMSBrandname/SendSMS';
        $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c24iOiJyb3lhbHNwYSIsInNpZCI6ImFmZTIxOWQ4LTdhM2UtNDA5MS05NjBmLThmZjViNGI4NzRhMiIsIm9idCI6IiIsIm9iaiI6IiIsIm5iZiI6MTU4OTM1NDE4MCwiZXhwIjoxNTg5MzU3NzgwLCJpYXQiOjE1ODkzNTQxODB9.Hx8r30IR1nqAkOClihx0n9upfvgOg1f-E3MwNEwWT-0';
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $base_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "token: $token"
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $error_code = json_decode($response)->errorCode;
//        $err = Functions::sendSmsV3('0975091435', 'Test tin he thong');

        return $error_code;


//        $arr = Customer::select('id')->where('branch_id', 1)->pluck('id')->toArray();
//        $arr = CustomerGroup::select('customer_id')->where('branch_id', 0)->pluck('customer_id')->toArray();
//        $customer2 = Customer::find($arr)->pluck('branch_id', 'id')->toArray();
////        foreach (array_chunk($customer2, 1000) as $key => $item) {
//        foreach ($customer2 as $key => $item) {
//        CustomerGroup::where('customer_id', $key)->update(['branch_id' => $item]);
//        }
    }
}
