<?php
/**
 * Created by PhpStorm.
 * User: Ominext
 * Date: 2019-06-25
 * Time: 10:59 AM
 */

namespace App\Services;

use App\Models\ProductDepot;

class ProductDepostService
{
    public $product;

    public function __construct(ProductDepot $product)
    {
        $this->product = $product;
    }

    public function create(array $data)
    {
        if (empty($data)) return false;
        $model = $this->product->create($data);
        return $model;
    }

    public function update($id, array $data)
    {
        if (empty($data)) return false;
        $model = $this->find($id);
        $model->update($data);
        return $model;
    }

    public function find($id)
    {
        $model = $this->product->find($id);

        return $model;
    }

    public function delete($id)
    {
        $model = $this->find($id);

        return $model->delete();

    }
}
