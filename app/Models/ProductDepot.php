<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDepot extends Model
{
    protected $guarded = [];

    public static function search($input)
    {
        $data = self::when(!empty($input['depot_id']), function ($q) use ($input) {
            $q->where('depot_id', $input['depot_id']);
        })->when(!empty($input['product_id']), function ($q) use ($input) {
            $q->where('product_id', $input['product_id']);
        })->when(!empty($input['name']), function ($q) use ($input) {
            $products = Services::where('name', 'like', '%' . $input['name'] . '%')->pluck('id')->toArray();
            $q->whereIn('product_id', $products);
        })->orderByDesc('updated_at');

        return $data;
    }

    public function product()
    {
        return $this->belongsTo(Services::class, 'product_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
}
