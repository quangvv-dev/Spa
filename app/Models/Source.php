<?php

namespace App\Models;

use App\Constants\StatusConstant;
use App\Helpers\Functions;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class,'mkt_id');
    }
    public function branch(){
        return $this->belongsTo(Branch::class);
    }

    public function getCategoryTextAttribute()
    {
        if($this->category_id){
            $products = Category::whereIn('id', json_decode($this->category_id))->pluck('name')->toArray();
            return implode(', ', $products);
        }
        return '';
    }
    public function getSaleTextAttribute()
    {
        if($this->sale_id){
            $products = User::whereIn('id', json_decode($this->sale_id))->pluck('full_name')->toArray();
            return implode(', ', $products);
        }
        return '';
    }

    public static function search($search)
    {
        $docs = self::when(isset($search['start_date']) && isset($search['end_date']), function ($query) use ($search) {
            $query->whereBetween('updated_at', [
                Functions::yearMonthDayTime($search['start_date']),
                Functions::yearMonthDayTime($search['end_date']),
            ]);
        })->when(isset($search['searchName']) && $search['searchName'], function ($query) use ($search) {
            return $query->where('name', 'like', '%' . $search['searchName'] . '%');
        })->when(isset($search['searchType']) && $search['searchType'], function ($query) use ($search) {
            if ($search['searchType'] == StatusConstant::TYPE_CONNECT_WEBSITE) {
                return $query->whereIn('type', [StatusConstant::TYPE_CONNECT_WEBSITE]);
            } else {
                return $query->where('type', $search['searchType']);
            }
        })->when(isset($search['searchArrayUser']) && $search['searchArrayUser'], function ($query) use ($search) {
            return $query->whereIn('mkt_id', $search['searchArrayUser']);
        })->when(isset($search['searchUser']) && $search['searchUser'], function ($query) use ($search) {
            return $query->where('mkt_id', $search['searchUser']);
        })->when(isset($search['searchId']) && $search['searchId'], function ($query) use ($search) {
            return $query->where('id', $search['searchId']);
        })->when(isset($search['searchChanel']) && $search['searchChanel'], function ($query) use ($search) {
            return $query->where('chanel', $search['searchChanel']);
        })->when(isset($search['searchAccept']) && $search['searchAccept'], function ($query) use ($search) {
            return $query->where('accept', $search['searchAccept']);
        })->when(isset($search['searchCategory']) && $search['searchCategory'], function ($query) use ($search) {
            return $query->where('category_id', 'like', '%"' . $search['searchCategory'] . '"%');
        })->when(isset($search['searchId']) && $search['searchId'], function ($query) use ($search) {
            return $query->where('id', $search['searchId']);
        })->when(isset($search['searchBranch']) && $search['searchBranch'], function ($query) use ($search) {
            return $query->where('branch_id', $search['searchBranch']);
        })->orderBy('updated_at', 'desc');
        return $docs;
    }
}
