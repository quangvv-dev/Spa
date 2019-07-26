<?php

namespace App\Models;

use App\Constants\StatusCode;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $guarded = ['id'];
    protected $table = 'status';
    public $timestamps = false;

    public function customers()
    {
        return $this->hasMany(Customer::class, 'status_id', 'id');
    }

    public static function getRelationship()
    {
        return self::with('customers')->where('type', StatusCode::RELATIONSHIP)->get();
    }
}
