<?php

namespace App\Models\Proposal;

use Illuminate\Database\Eloquent\Model;

class MusicProposal extends BaseProposal
{
    protected $table = 'music_proposals';

    public function music()
    {
        return $this->belongsTo('App\Models\Music\Music', 'music_id', 'id');
    }

}
