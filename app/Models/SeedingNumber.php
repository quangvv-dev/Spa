<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class SeedingNumber extends Model
{
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public static function search($search)
    {
        $docs = self::when(isset($search['searchPhone']) && $search['searchPhone'], function ($query) use ($search) {
            return $query->where('seeding_number', 'like', '%' . $search['searchPhone'] . '%');
        })->orderBy('id', 'desc');
        return $docs;
    }
}
