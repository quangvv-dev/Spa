<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RuleOutput extends Model
{
    protected $table = 'rules_output';
    protected $guarded = ['id'];
    protected $fillable = [
        'rule_id',
        'event',
        'actor',
        'action',
        'configs',
        'status'
    ];

    public function rules()
    {
        return $this->belongsTo(Rule::class, 'rule_id','id');
    }
}
