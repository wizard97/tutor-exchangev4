<?php

namespace App\Models\MiddleSubject;

use Illuminate\Database\Eloquent\Model;

class MiddleSubject extends Model
{
    protected $table = 'middle_subjects';
    protected $fillable = ['subject_name'];

    public function classes()
    {
        return $this->hasMany('App\Models\MiddleClass\MiddleClass', 'middle_subject_id', 'id');
    }

}
