<?php
/**
 * Created by PhpStorm.
 * User: QuangQA
 * Date: 2019-06-25
 * Time: 10:59 AM
 */

namespace App\Services;

use Illuminate\Support\Carbon;
use App\Models\UserPersonal;

class UserPersonalService
{
    public $contact;

    public function __construct(UserPersonal $personal)
    {
        $this->personal = $personal;
    }

    public function create(array $data)
    {
        if (empty($data)) {
            return false;
        }
        $model = $this->personal->create($data);
        return $model;
    }

    public function find($id)
    {
        $model = $this->personal->find($id);

        return $model;
    }

    public function delete($id)
    {
        $model = $this->find($id);

        return $model->delete();

    }

    public function compareData($params)
    {
        foreach ($params as $key => $item) {
            $date = \DateTime::createFromFormat('d/m/Y', $item);
            if ($date && $date->format('d/m/Y') === $item) {
                $params[$key] = Carbon::createFromFormat('d/m/Y', $item)->format('Y-m-d');
            }
        }
        return $params;
    }
}
