<?php

namespace App\Models;

use App\Helpers\Functions;
use App\User;
use Illuminate\Database\Eloquent\Model;

class CustomerCampaign extends Model
{
    protected $guarded = ['id'];
    protected $table = 'customer_campaign';
    public $timestamps = false;

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function sale()
    {
        return $this->belongsTo(User::class);
    }

    public function cskh()
    {
        return $this->belongsTo(User::class);
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public static function search($input)
    {
        $data = self::when(isset($input['campaign_id']) && $input['campaign_id'], function ($query) use ($input) {
            $query->where('campaign_id', $input['campaign_id']);
        })->when(isset($input['sale_id']) && $input['sale_id'], function ($query) use ($input) {
            $query->where('sale_id', $input['sale_id']);
        })->when(isset($input['cskh_id']) && $input['cskh_id'], function ($query) use ($input) {
            $query->where('cskh_id', $input['cskh_id']);
        });

        return $data->orderByDesc('id');
    }
}
