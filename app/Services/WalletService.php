<?php
/**
 * Created by PhpStorm.
 * User: Ominext
 * Date: 2019-06-25
 * Time: 10:59 AM
 */

namespace App\Services;

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
}
