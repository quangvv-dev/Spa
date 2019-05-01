<?php

namespace App\Models;

use App\Constants\UserConstant;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    protected $guarded = ['id'];
    protected $table = 'services';

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function getActiveTextAttribute()
    {
        return $this->enable == UserConstant::ACTIVE ? 'Hoạt động' : 'Ngừng hoạt động';
    }

    public function getImagesAttribute($images)
    {
        return @json_decode($images, true);
    }
}
