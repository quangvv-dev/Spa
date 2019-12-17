<?php
/**
 * Created by PhpStorm.
 * User: Ominext
 * Date: 2019-06-25
 * Time: 10:59 AM
 */

namespace App\Services;


use App\Models\Commission;

class CommissionService
{
    public $commission;

    public function __construct( Commission $commission)
    {
        $this->commission = $commission;
    }

    public function create(array $data, $orderId)
    {
        if (empty($data)) return false;

        $dataArr = [];

        foreach ($data['user_id'] as $key => $val) {
            $data['earn'][$key] = replaceNumberFormat($data['earn'][$key]);

            if (!empty($data['id'][$key])) {
                $model = $this->find($data['id'][$key]);

                $model->update([
                    'user_id'  => $data['user_id'][$key],
                    'percent'  => $data['percent'][$key],
                    'note'     => $data['note'][$key],
                    'earn'     => $data['earn'][$key]
                ]);
            } else {
                $dataArr[] = [
                    'user_id'  => $data['user_id'][$key],
                    'percent'  => $data['percent'][$key],
                    'note'     => $data['note'][$key],
                    'order_id' => $orderId,
                    'earn'     => $data['earn'][$key]
                ];
            }
        }

        if (!empty($dataArr)) {
            $model = Commission::insert($dataArr);

            return $model;
        }
    }

    public function find($id)
    {
        $model = $this->commission->where('id', $id)->first();

        return $model;
    }

    public function delete($id)
    {
        $model = $this->find($id);

        return $model->delete();

    }
}
