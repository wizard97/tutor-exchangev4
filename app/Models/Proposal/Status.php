<?php

namespace App\Models\Proposal;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'statuses';
    public $timestamps = false;

    public function getStatusId($slug)
    {
        return $this->where('slug', $slug)->firstOrFail()->id;
    }

    public function proposals()
    {
        return $this->hasMany('App\Models\Proposal\Proposal');
    }
}
