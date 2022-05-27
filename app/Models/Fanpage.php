<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Fanpage extends Model
{
    protected $guarded = [];

    public static function search($search)
    {
        $docs = self::when(isset($search['searchUser']), function ($q) use ($search) {
            return $q->where('user_id', $search['searchUser']);
        })->when(isset($search['arr_mkt_id']) && count($search['arr_mkt_id']), function ($q) use ($search) {
            return $q->whereIn('user_id', $search['arr_mkt_id']);
        })->when(isset($search['searchPageId']), function ($q) use ($search) {
            return $q->where('page_id', $search['searchPageId']);
        })->when(isset($search['used']), function ($q) use ($search) {
            return $q->where('used', $search['used']);
        })->when(isset($search['searchName']) && $search['searchName'], function ($q) use ($search) {
            return $q->where('name', 'like', '%' . $search['searchName'] . '%');
        })->orderByDesc('id');
        return $docs;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function source()
    {
        return $this->belongsTo(Source::class, 'source_id');
    }
}
