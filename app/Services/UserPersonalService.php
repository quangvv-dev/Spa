<?php
/**
 * Created by PhpStorm.
 * User: QuangQA
 * Date: 2019-06-25
 * Time: 10:59 AM
 */

namespace App\Services;

use App\Helpers\Functions;
use Illuminate\Support\Carbon;
use App\Models\UserPersonal;
use Illuminate\Support\Facades\DB;

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

    public function chart($input)
    {
        return UserPersonal::join('leave_reasons as lr', 'lr.id', '=', 'user_personal.leave_reason_id')
            ->join('users as u', 'u.id', '=', 'user_personal.user_id')
            ->when(!empty($input['start_date']), function ($query) use ($input) {
                $query->whereBetween('user_personal.leave_time', [
                    Functions::yearMonthDay($input['start_date']) . " 00:00:00",
                    Functions::yearMonthDay($input['end_date']) . " 23:59:59",
                ]);
            })
            ->when(!empty($input['department_id']), function ($query) use ($input) {
                $query->where('u.department_id', $input['department_id']);
            })->when(!empty($input['branch_id']), function ($query) use ($input) {
                $query->where('u.branch_id', $input['branch_id']);
            })->when(!empty($input['group_branch']), function ($query) use ($input) {
                $query->whereIn('u.branch_id', $input['group_branch']);
            })
            ->select('lr.name', DB::raw('COUNT(user_id) as total'))
            ->groupBy('lr.id')->get();
    }

}
