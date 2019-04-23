<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = ['id'];
    protected $table = 'categories';

    //không viết quan hệ ở đây à: làm gì cần ???

    public function categories()
    {
        return $this->belongsTo(Category::class,'parent_id');
    }
}
