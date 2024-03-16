<?php

namespace App\Models;

use App\Constants\OrderConstant;
use App\Helpers\Functions;
use App\User;
use Illuminate\Database\Eloquent\Model;

class CustomerCampaign extends Model
{
    protected $guarded = ['id'];
    protected $table = 'customer_campaign';
    public $timestamps = false;
    public const NEW = 0;
    public const CHUA_KET_NOI = 1;
    public const DA_HEN_LICH = 2;
    public const DA_MUA_HANG = 3;

    public const statusLabel = [
        self::NEW          => 'Mới',
        self::CHUA_KET_NOI => 'Chưa kết nối',
        self::DA_HEN_LICH  => 'Đã hẹn lịch',
        self::DA_MUA_HANG  => 'Đã mua hàng',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'member_id', 'customer_id')
            ->where('is_upsale', OrderConstant::IS_UPSALE)
            ->whereBetween('created_at',
                [$this->campaign->start_date . ' 00:00:00', $this->campaign->end_date . ' 23:59:59']);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function sale()
    {
        return $this->belongsTo(User::class);
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public static function search($input)
    {
        $data = self::when(isset($input['search']) && $input['search'], function ($query) use ($input) {
            $query->whereHas('customer', function ($qr) use ($input) {
                $qr->where('phone', $input['search']);
            });
        })->when(isset($input['branch_id']) && $input['branch_id'], function ($query) use ($input) {
            $query->whereHas('customer', function ($qr) use ($input) {
                $qr->where('branch_id', $input['branch_id']);
            });
        })->when(isset($input['campaign_id']) && $input['campaign_id'], function ($query) use ($input) {
            $query->where('campaign_id', $input['campaign_id']);
        })->when(isset($input['status']) && $input['status'], function ($query) use ($input) {
            $query->where('status', $input['status']);
        })->when(isset($input['sale_id']) && $input['sale_id'], function ($query) use ($input) {
            $query->where('sale_id', $input['sale_id']);
        });

        return $data->orderByDesc('id');
    }
}
