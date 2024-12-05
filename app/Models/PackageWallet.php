<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PackageWallet extends Model
{
    protected $guarded = ['id'];
    use SoftDeletes;


    public static function search($input)
    {
        $data = self::when(isset($input['search']), function ($query) use ($input) {
            $query->where('name', 'like', '%' . $input['search'] . '%')
                ->orWhere('order_price', 'like', '%' . $input['search'] . '%')
                ->orWhere('price', 'like', '%' . $input['search'] . '%');
        });
        return $data;
    }
}
