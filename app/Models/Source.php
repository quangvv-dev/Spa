<?php

namespace App\Models;

use App\Constants\SocialConstant;
use App\Constants\StatusConstant;
use App\Helpers\Functions;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'mkt_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function getCategoryTextAttribute()
    {
        if ($this->category_id) {
            $products = Category::whereIn('id', json_decode($this->category_id))->pluck('name')->toArray();
            return implode(', ', $products);
        }
        return '';
    }

    public function getChanelTextAttribute()
    {
        $chanel = [
            SocialConstant::GOOGLE_ADS => 'Google Ads',
            SocialConstant::FACEBOOK_ADS => 'Facebook Ads',
            SocialConstant::ZALO_ADS => 'Zalo Ads',
            SocialConstant::TIKTOK_ADS => 'Tiktok Ads',
        ];
        if ($this->chanel) {
            $value = isset($chanel[$this->chanel]) ? $chanel[$this->chanel] : 'Facebook Ads';
            return $value;
        }
        return '';
    }

    public function getSaleTextAttribute()
    {
        if ($this->sale_id) {
            $products = User::whereIn('id', json_decode($this->sale_id))->pluck('full_name')->toArray();
            return implode(', ', $products);
        }
        return '';
    }

    public static function search($search)
    {
        $docs = self::when(isset($search['start_date']) && isset($search['end_date']), function ($query) use ($search) {
            $query->whereBetween('updated_at', [
                Functions::yearMonthDay($search['start_date']).' 00:00',
                Functions::yearMonthDay($search['end_date']).' 23:59',
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
        })->when(isset($search['mkt_id']) && $search['mkt_id'], function ($query) use ($search) {
            return $query->where('mkt_id', $search['mkt_id']);
        })->when(isset($search['searchChanel']) && $search['searchChanel'], function ($query) use ($search) {
            return $query->where('chanel', $search['searchChanel']);
        })->when(isset($search['searchAccept']) && $search['searchAccept'], function ($query) use ($search) {
            return $query->where('accept', $search['searchAccept']);
        })->when(isset($search['category_id']) && $search['category_id'], function ($query) use ($search) {
            return $query->where('category_id', 'like', '%"' . $search['category_id'] . '"%');
        })->when(isset($search['searchId']) && $search['searchId'], function ($query) use ($search) {
            return $query->where('id', $search['searchId']);
        })->when(isset($search['branch_id']) && $search['branch_id'], function ($query) use ($search) {
            return $query->where('branch_id', $search['branch_id']);
        })->when(isset($search['group_branch']) && count($search['group_branch']), function ($q) use ($search) {
            $q->whereIn('branch_id', $search['group_branch']);
        })->orderBy('updated_at', 'desc');
        return $docs;
    }
}
