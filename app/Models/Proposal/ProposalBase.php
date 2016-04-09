<?php
namespace App\Models\Proposal;

use Illuminate\Database\Eloquent\Model;

class BaseProposal extends Model
{
    public $timestamps = false;

    public function proposal()
    {
        return $this->morphToMany('App\Models\Proposal\Proposal', 'proposable');
        //return $this->belongsTo('App\Models\Proposal\Proposal', 'proposal_id', 'id');
    }
}
