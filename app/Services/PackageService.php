<?php
/**
 * Created by PhpStorm.
 * User: Ominext
 * Date: 2019-06-25
 * Time: 10:59 AM
 */

namespace App\Services;

use App\Models\PackageWallet;

class PackageService
{
    public $wallet_history;

    public function __construct(PackageWallet $wallet)
    {
        $this->wallet = $wallet;
    }

    public function create(array $data)
    {
        if (empty($data)) return false;
        $model = $this->wallet->create($data);
        return $model;
    }

    public function update($input, $id)
    {
        $model = $this->find($id);
        if (empty($model)) return false;
        $model->update($input);
        return $model;
    }

    public function find($id)
    {
        $model = $this->wallet->find($id);

        return $model;
    }

    public function delete($id)
    {
        $model = $this->find($id);

        return $model->delete();

    }
}
