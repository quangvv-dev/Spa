<?php

namespace App\Models;

use App\Constants\ChamCongConstant;
use App\User;
use Illuminate\Database\Eloquent\Model;

class DonTu extends Model
{
    protected $guarded = [];
    public $time = ChamCongConstant::HOURS;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function reason(){
        return $this->belongsTo(Reason::class);
    }

    public function getTimeTextAttribute(){
        $key = array_search($this->time_to, $this->time);
        return $key;
    }
    public function getTimeEndTextAttribute(){
        if($this->time_end){
            $key = array_search($this->time_end, $this->time);
            return $key;
        } else {
            return '';
        }
    }

    public function getDateTextAttribute(){
        if($this->time_end && $this->date_end){
            $key_time_to = array_search($this->time_to, $this->time);
            $key_time_end = array_search($this->time_end, $this->time);

            $date_start = $this->date.' '.$key_time_to;
            $date_end = $this->date_end.' '.$key_time_end;
            $ngonngay = strtotime($date_end)-strtotime($date_start);
            $ngay = floor($ngonngay/86400);
            $gio = floor(($ngonngay%86400)/3600);

            $abc = floor(($ngonngay/3600)%24)/8;
            if($ngay > 0){
                $date1 = $ngay .' ngày ' . round($abc,1);
            } else {
                $date1 = round($abc,1) . ' ngày';
            }


            $text = '';
            if($ngay > 0){
                $text = $ngay . ' ngày';
            }
            if($gio > 0){
                $text = $text. ' ' . $gio . ' giờ';
            }

            $data['so_ngay'] = $text;
            $data['so_ngay_cong'] = $date1;
            return $data;
        } else {
            $data['so_ngay'] = '';
            $data['so_ngay_cong'] = '';
            return $data;
        }
    }
}
