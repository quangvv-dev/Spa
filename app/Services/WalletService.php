<?php
/**
 * Created by PhpStorm.
 * User: Ominext
 * Date: 2019-06-25
 * Time: 10:59 AM
 */

namespace App\Services;

use App\Models\Customer;
use App\Models\HistoryWalletCtv;
use App\Models\WalletHistory;

class WalletService
{
    public $wallet_history;

    public function __construct(WalletHistory $wallet_history)
    {
        $this->wallet_history = $wallet_history;
    }

    public function create(array $data)
    {
        if (empty($data)) return false;
        $model = $this->wallet_history->create($data);
        return $model;
    }

    public function find($id)
    {
        $model = $this->wallet_history->find($id);

        return $model;
    }

    public function delete($id)
    {
        $model = $this->find($id);

        return $model->delete();

    }

    public static function exchangeWalletCtv($price, $customer_id, $payment_history_id)
    {
        $exchange = ($price / 100) * setting('exchange');
        HistoryWalletCtv::create([
            'customer_id' => $customer_id,
            'price' => $exchange,
            'type' => 1,
            'description' => 'Hệ thống cộng hoa hồng',
            'percent' => setting('exchange'),
            'payment_history_id' => $payment_history_id
        ]);
        $gioithieu = Customer::find($customer_id);
        if (isset($gioithieu) && $gioithieu) {
            $gioithieu->wallet_ctv = (int)$gioithieu->wallet_ctv + (int)$exchange;
            $gioithieu->save();
        }
    }
}
