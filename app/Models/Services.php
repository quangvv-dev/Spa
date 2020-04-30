<?php

namespace App\Models;

use App\Constants\StatusCode;
use App\Constants\UserConstant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Services extends Model
{
    protected $guarded = ['id'];
    protected $table = 'services';
    use SoftDeletes;

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function getActiveTextAttribute()
    {
        return $this->enable == UserConstant::ACTIVE ? 'Hoạt động' : 'Ngừng hoạt động';
    }

    public function orders()
    {
        return $this->hasMany(OrderDetail::class, 'booking_id', 'id');
    }

    public function getImagesAttribute($images)
    {
        return @json_decode($images, true);
    }

    public static function handleChart()
    {
        $data = self::where('type',StatusCode::PRODUCT)->with('orders')
            ->get();
        return $data;
    }
}
