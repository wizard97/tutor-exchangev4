<?php
namespace App\Models\Pending;

use Illuminate\Database\Eloquent\Model;

class PendingBase extends Model
{
    public $timestamps = false;

    public function proposal()
    {
    return $this->belongsTo('App\Models\Pending\Proposal', 'proposal_id', 'id');
    }
}
