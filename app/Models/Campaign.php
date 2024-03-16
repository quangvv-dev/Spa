<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helpers\Functions;

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

    public function getCskhTextAttribute()
    {
        $users = User::whereIn('id', json_decode($this->cskh_id))->pluck('full_name')->toArray();
        return count($users) ? implode('|', $users) : '';
    }

    public static function search($input)
    {
        $data = self::when(isset($input['search']) && $input['search'], function ($query) use ($input) {
            $query->where('name', 'like', '%' . $input['search'] . '%');
        })->when(isset($input['start_date']) && isset($input['end_date']), function ($q) use ($input) {
            $q->whereBetween('created_at', [
                Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                Functions::yearMonthDay($input['end_date']) . " 23:59:59",
            ]);
        });

        return $data->orderByDesc('updated_at');
    }
}
