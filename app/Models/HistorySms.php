<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorySms extends Model
{
    protected $guarded = ['id'];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class, 'campaign_id')->withTrashed();
    }
}
