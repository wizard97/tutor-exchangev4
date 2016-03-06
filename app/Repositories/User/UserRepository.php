<?php
namespace App\Repositories\User;

use App\Repositories\BaseRepository;

use App\Models\User\User;
use DB;
use Debugbar;
class UserRepository extends BaseRepository implements UserRepositoryContract
{

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
    * Returns all the possible recepients from a query (data is client side safe)
    *
    * @return mixed
    */
    public function possibleRecipientsQuery($query, $user_id)
    {
        $keys = preg_split("/[\s,.]+/", trim(urldecode($query)));


        $res = $this->model->safeUserInfo()->where('users.id', '!=', $user_id);

        foreach ($keys as $k)
        {
            $res->where(function ($query) use ($k)
            {
                $query->orWhere('users.fname', 'LIKE', '%'.$k.'%');
                $query->orWhere('users.lname', 'LIKE', '%'.$k.'%');
                $query->orWhere('zips.city', 'LIKE', '%'.$k.'%');
                $query->orWhere('zips.state_prefix', 'LIKE', '%'.$k.'%');

            });
        }

        return $res->take(10)->get();
    }

    /**
    * Returns prefetch for user searches (data is client side safe)
    *
    * @return mixed
    */
    public function possibleRecipientsPrefetch($user_id)
    {
        return $this->model->safeUserInfo()
        ->where('users.id', '!=', $user_id)
        ->take(20)->get();
    }
}
