<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoryWalletCtv extends Model
{
    protected $guarded = ['id'];
    protected $table = 'history_wallet_ctv';


    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
}
