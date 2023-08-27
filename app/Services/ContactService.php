<?php
/**
 * Created by PhpStorm.
 * User: Ominext
 * Date: 2019-06-25
 * Time: 10:59 AM
 */

namespace App\Services;

use App\Constants\StatusCode;
use App\Model\Contact;
use App\Models\Customer;
use App\Models\HistoryWalletCtv;

class ContactService
{
    public $contact;

    public function __construct(Contact $contact)
    {
        $this->wallet_history = $contact;
    }

    public function getAll($params = [], $select = ['*'])
    {
        $model = $this->wallet_history->select($select);
        if (count($params)) {
            foreach ($params as $key => $value) {
                if (!empty($value)) {
                    if (is_numeric($value)) {
                        $model = $model->where($key, $value);
                    } elseif (is_string($value)) {
                        $model = $model->where($key, 'like', '%' . $value . '%');
                    }
                }
            }
        }
        return $model;
    }

    public function create(array $data)
    {
        if (empty($data)) {
            return false;
        }
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
