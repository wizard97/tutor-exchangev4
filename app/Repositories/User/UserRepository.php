<?php
namespace App\Repositories\User;

use App\Repositories\BaseRepository;

use App\Models\User\User;
use DB;

class UserRepository extends BaseRepository implements UserRepositoryContract
{

  public function __construct(User $model)
  {
    $this->model = $model;
  }
  public function possibleRecipientsQuery($query)
  {
    $user = \Auth::user();
    $keys = preg_split("/[,.]+/", trim(urldecode($query)));
    $num_keys = count($keys);
    $search = User::where(function ($query) use($keys){
      foreach($keys as $key) {
        $query->orWhere('fname', 'LIKE', '%'.$key.'%')
        ->orWhere('lname', 'LIKE', '%'.$key.'%');
      }
    })
    //->select('fname', 'lname', 'id')
    ->where('users.id', '!=', $user->id)
    ->select(DB::raw("CONCAT(users.fname,' ',users.lname) AS full_name"), 'id')
    ->take(10)
    ->get();
    return $search;
  }
  public function possibleRecipientsPrefetch()
  {
    $user = \Auth::user();
    $prefetch = User::all()
    //->select('fname', 'lname', 'id')
    ->where('users.id', '!=', $user->id)
    ->select(DB::raw("CONCAT(users.fname,' ',users.lname) AS full_name"), 'id')
    ->take(100);
    return $prefetch;
  }
}
