<?php

namespace App\Services;

use App\Models\TokenZalOa;

class ZaloService
{
    public function getTokenOa()
    {
        return TokenZalOa::first();
    }

    public function saveTokenZalo()
    {
        $oa = $this->getTokenOa();
        if (empty($oa)) {
            return false;
        }

        $payload = [
            'refresh_token' => $oa->refresh_token,
            'app_id' => config('partners.zalo_zns.app_id'),
            'grant_type' => 'refresh_token'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, config('partners.zalo_zns.url_oa'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
        $secret_key = 'secret_key: ' . config('partners.zalo_zns.secret_key');
        $headers = [
            'Content-Type: application/x-www-form-urlencoded; charset=utf-8',
            $secret_key,
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $server_output = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($server_output);
        if (empty($result->refresh_token)) {
            return false;
        }
        TokenZalOa::truncate();
        TokenZalOa::create([
            'refresh_token' => $result->refresh_token,
            'access_token' => $result->access_token
        ]);
    }

    public function compareDataSchedule($schedule)
    {
        return [
            'customer_name' => @$schedule->customer->full_name,
            'time_from' => $schedule->time_from,
            'time_to' => $schedule->time_to,
            'date' => date('d/m/Y', strtotime($schedule->date)),
            'address' => @$schedule->branch->address??"...",
            'code' => 'LH.' . $schedule->id,
        ];
    }

}
