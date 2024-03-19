<?php

namespace App\Models;

use App\Constants\OrderConstant;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helpers\Functions;
use Illuminate\Support\Facades\DB;

class Campaign extends Model
{
    protected $guarded = ['id'];
    use SoftDeletes;

    public function customer_campaign()
    {
        return $this->hasMany(CustomerCampaign::class);
    }

    public function getStatusTextAttribute()
    {
        $status = Status::whereIn('id', json_decode($this->customer_status))->pluck('name')->toArray();
        return count($status) ? implode(' |', $status) : '';
    }

    public function getOrderValueAttribute()
    {
        return CustomerCampaign::select(DB::raw('SUM(o.all_total) as all_total'))
            ->join('orders as o', 'customer_campaign.customer_id', '=', 'o.member_id')
            ->whereBetween('o.created_at', [
                $this->start_date . " 00:00:00",
                $this->end_date . " 23:59:59",
            ])
            ->where('o.is_upsale', OrderConstant::IS_UPSALE)
            ->where('customer_campaign.campaign_id', $this->id)
            ->groupBy('customer_campaign.campaign_id')
            ->get()->sum('all_total');
//        return [
//            'all_total' => $data->sum('all_total'),
//            'order_total' => $data->sum('order_total')
//        ];
    }

    public function getBranchTextAttribute()
    {
        $branch = Branch::whereIn('id', json_decode($this->branch_id))->pluck('name')->toArray();
        return count($branch) ? implode(' |', $branch) : '';
    }

    public function getSaleTextAttribute()
    {
        $users = User::whereIn('id', json_decode($this->sale_id))->pluck('full_name')->toArray();
        return count($users) ? implode(' |', $users) : '';
    }

    public function getSaleRelationAttribute()
    {
        $users = User::select('id', 'full_name')->whereIn('id', json_decode($this->sale_id))->get();
        return count($users) ? json_encode($users) : null;
    }

    public static function search($input)
    {
        $data = self::when(isset($input['search']) && $input['search'], function ($query) use ($input) {
            $query->where('name', 'like', '%' . $input['search'] . '%');
        })->when(isset($input['branch_id']) && $input['branch_id'], function ($query) use ($input) {
            $query->where('branch_id', 'like', '%' . $input['branch_id'] . '%');
        })->when(isset($input['start_date']) && isset($input['end_date']), function ($q) use ($input) {
            $q->whereBetween('created_at', [
                Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                Functions::yearMonthDay($input['end_date']) . " 23:59:59",
            ]);
        });

        return $data->orderByDesc('updated_at');
    }
}
