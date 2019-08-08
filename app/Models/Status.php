<?php

namespace App\Models;

use App\Constants\StatusCode;
use App\Services\OrderService;
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
        return self::with('customers.orders')->where('type', StatusCode::RELATIONSHIP)->get();
    }


    public static function getRevennueSource()
    {
        $data = self::with('customers.orders')
            ->where('type', StatusCode::SOURCE_CUSTOMER)
            ->get();

        return OrderService::handleData($data);
    }

    public static function getRevennueSourceByRelation()
    {
        $data = self::getRelationship();

        return OrderService::handleData($data);
    }
}
