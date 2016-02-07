<?php
namespace App\Repositories\User;

use App\Repositories\BaseRepository;

use App\Models\User\User;

class UserRepository extends BaseRepository implements UserRepositoryContract
{

  public function __construct(User $model)
  {
    $this->model = $model;
  }

}
