<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuickReply extends Model
{
    protected $guarded = [];

    public function getImagesAttribute($images)
    {
        return @json_decode($images, true);
    }
}
