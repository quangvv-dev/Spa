<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    protected $guarded = [];

    public function historySalary(){
        return $this->belongsTo(HistoryImportSalary::class,'history_import_salary_id','id');
    }
}
