<?php

namespace App\Models\Messenger;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\Config;

class Message extends Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'messages';

    /**
     * The relationships that should be touched on save.
     *
     * @var array
     */
    protected $touches = ['thread'];

    /**
     * The attributes that can be set with Mass Assignment.
     *
     * @var array
     */
    protected $fillable = ['thread_id', 'user_id', 'body'];

    /**
     * Validation rules.
     *
     * @var array
     */
    protected $rules = [
        'body' => 'required',
    ];

        /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:s';

    /**
     * Thread relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function thread()
    {
        return $this->belongsTo(Config::get('messenger.thread_model'), 'thread_id', 'id');
    }

    /**
     * User relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(Config::get('messenger.user_model'), 'user_id', 'id');
    }

    /**
     * Participants relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function participants()
    {
        return $this->hasMany(Config::get('messenger.participant_model'), 'thread_id', 'thread_id');
    }

    /**
     * Recipients of this message.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recipients()
    {
        return $this->participants()->where('user_id', '!=', $this->user_id);
    }


    /**
     * Returns messages adressed for user.
     *
     * @param $query
     * @param $userId
     * @return mixed
     */
    public function scopeForUser($query, $userId)
    {
      $participantTable = $this->getParticipantTable();
        return $query
          ->join($participantTable, $participantTable. '.thread_id', '=', $this->getTable(). '.thread_id')
          ->where($participantTable . '.user_id', $userId)
          ->whereNull($participantTable . '.deleted_at')
          ->where($this->getTable().'.user_id', '!=', $userId)
          ->select($this->getTable().'.*');
    }


    /**
     * Returns messages adressed from user.
     *
     * @param $query
     * @param $userId
     * @return mixed
     */
    public function scopeFromUser($query, $userId)
    {
      $participantTable = $this->getParticipantTable();

        return $query
          ->join($participantTable, $participantTable. '.thread_id', '=', $this->getTable(). '.thread_id')
          ->where($participantTable . '.user_id', $userId)
          ->whereNull($participantTable . '.deleted_at')
          ->where($this->getTable().'.user_id', '=', $userId)
          ->select($this->getTable().'.*');
    }

    public function scopeForUserUnread($query, $userId)
    {
      return $query->forUser($userId)
        ->where(function ($query) {
          $query->where('messages.updated_at', '>', \DB::raw("`participants`.`last_read`"))
            ->orWhereNull('participants.last_read');
      });
    }
    /**
     * See if the current thread is unread by the user.
     *
     * @param integer $userId
     * @return bool
     */
    public function isUnread($userId)
    {
        try {
            $participant = $this->getParticipant($userId);
            if (is_null($participant->last_read)) return true;
            return ($this->updated_at->gt($participant->last_read));

        } catch (ModelNotFoundException $e) {
            // do nothing
        }

        return false;
    }

    public function hasReply($userId)
    {
      return $this->where('messages.thread_id', $this->thread_id)->where('messages.user_id', $userId)
          ->where('messages.created_at', '>=', $this->created_at)->count() > 0;
    }

    /**
     * Returns the "participant" model for this message with $user_id
     *
     * @return string
     */
    public function getParticipant($userId)
    {
      return $this->participants()->where('participants.user_id', '=', $userId)->firstOrFail();
    }

    /**
     * Returns the "participant" models for all recepients
     *
     * @return string
     */
    public function getRecipientParticipants()
    {
      return $this->participants()->where('participants.user_id', '!=', $this->user_id)->get();
    }

    public function isReplyForUser($userId)
    {
      return !empty($this->where('thread_id', $this->thread->id)
          ->where('created_at', '<', $this->created_at)
          ->first());
    }

    /**
     * Returns the "participant" table name to use in manual queries.
     *
     * @return string
     */
    private function getParticipantTable()
    {
        if ($this->participantTable !== null) {
            return $this->participantTable;
        }

        $participantModel = Config::get('messenger.participant_model');

        return $this->participantTable = (new $participantModel)->getTable();
    }

}
