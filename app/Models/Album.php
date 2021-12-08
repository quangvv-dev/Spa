<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $guarded = ['id'];
    protected $table = 'albums';

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public static function search($input)
    {
        $data = self::orderBy('id', 'desc')
            ->when(isset($input['phone']), function ($query) use ($input) {
                $query->whereHas('customer', function ($qr) use ($input) {
                    $qr->where('phone', $input['phone']);
                });
            });

        return $data;
    }
}
