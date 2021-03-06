<?php

namespace App\Models\Pending;

use Illuminate\Database\Eloquent\Model;

class PendingMusic extends PendingBase
{
    protected $table = 'pending_music';

    public function music()
    {
        return $this->belongsTo('App\Models\Music\Music', 'music_id', 'id');
    }

}
