<?php
/**
 * Created by PhpStorm.
 * User: Ominext
 * Date: 2019-06-25
 * Time: 10:59 AM
 */

namespace App\Services;

use App\Models\PersonalImage;

class PersonalImageService
{
    public $contact;

    public function __construct(PersonalImage $personalImage)
    {
        $this->personal_image = $personalImage;
    }

    public function getAll($params = [], $select = ['*'])
    {
        $model = $this->personal_image->select($select);
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
        $model = $this->personal_image->create($data);
        return $model;
    }

    public function find($id)
    {
        $model = $this->personal_image->find($id);

        return $model;
    }

    public function delete($id)
    {
        $model = $this->find($id);

        return $model->delete();

    }
}
