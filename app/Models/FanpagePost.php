<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FanpagePost extends Model
{
    protected $guarded = [];

    public function fanpage()
    {
        return $this->belongsTo(Fanpage::class, 'page_id', 'page_id');
    }

    public function search($search)
    {
        $docs = self::when(isset($search['searchSourceId']) && $search['searchSourceId'], function ($q) use ($search) {
            return $q->where('source_id', $search['searchSourceId']);
        })->when(isset($search['searchPage_Post']) && $search['searchPage_Post'], function ($q) use ($search) {
            return $q->whereIn('page_id', $search['searchPage_Post']);
        })->when(isset($search['searchUseSource']) && $search['searchUseSource'], function ($q) use ($search) {
            return $q->where('source_id', '>', 0);
        })->when(isset($search['searchCustom']) && $search['searchCustom'], function ($q) use ($search) {
            return $q->where('post_id', $search['searchCustom'])->orWhere('title', 'like', '%' . $search['searchCustom'] . '%')->orWhere('page_id',$search['searchCustom']);
        })->orderByDesc('created_at');
        return $docs;
    }
}
