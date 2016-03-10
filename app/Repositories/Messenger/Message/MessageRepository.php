<?php
namespace App\Repositories\Messenger\Message;

use App\Repositories\BaseRepository;

use App\Models\Messenger\Message;

class MessageRepository extends BaseRepository implements MessageRepositoryContract
{

    public function __construct(Message $model)
    {
        $this->model = $model;
    }

    /**
    * Returns all of the latest threads by updated_at date.
    *
    * @return mixed
    */
    public function create($inputs, $thread, $user_id)
    {
        $m = new $this->model;
        $m->thread_id = $thread->id;
        $m->user_id = $user_id;
        $m->body = $inputs['message'];
        $m->save();
        return $m;
    }

    /**
    * Returns all of the latest messages with thread by updated_at date.
    *
    * @return mixed
    */
    public function getAllUsersLatest($user_id, $num_page=15)
    {
        return $this->model->with('thread')->latest('messages.updated_at')
            ->forUser($user_id)->paginate($num_page);
    }


    /**
    * Returns all of the users unread messages
    *
    * @return mixed
    */
    public function usersUnread($user_id)
    {
        return $this->model->forUserUnread($user_id)->get();
    }

    /**
    * Returns number of the users unread messages
    *
    * @return int
    */
    public function countUsersUnread($user_id)
    {
        return $this->model->forUserUnread($user_id)->count();
    }

}
