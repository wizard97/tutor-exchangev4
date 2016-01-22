<?php
namespace App\Repositories\School;

use App\Repositories\BaseRepository;

use App\Models\School\School;

class SchoolRepository extends BaseRepository implements SchoolRepositoryContract
{

  public function __construct(School $model)
  {
    $this->model = $model;
  }

  public function create($user_id)
  {

  }

  public function findBySearch($query)
  {
    return $this->matchBySearch($query)[0];
  }

  public function matchBySearch($query)
  {
    $keys = preg_split("/[\s,.]+/", trim(urldecode($query)), NULL, PREG_SPLIT_NO_EMPTY);

    $search = $this->model->join('zips', 'schools.zip_id', '=', 'zips.id');

    foreach ($keys as $key)
    {
      $search->where(function ($query) use ($key){
        $query->orWhere('schools.school_name', 'LIKE', '%'.$key.'%')
        ->orWhere('schools.address', 'LIKE', '%'.$key.'%')
        ->orWhere('schools.id', '=', $key)

        ->orWhere('zips.zip_code', 'LIKE', '%'.$key.'%')
        ->orWhere('zips.city', 'LIKE', '%'.$key.'%')
        ->orWhere('zips.state_prefix', 'LIKE', '%'.$key.'%');
      });
    }

    $matches = $search->select('zips.*', 'schools.school_name', 'schools.id AS school_id', \DB::raw("CONCAT_WS(', ', school_name, CONCAT(UCASE(LEFT(city, 1)),LCASE(SUBSTRING(city, 2))), CONCAT_WS(' ',state_prefix, zips.zip_code)) as response"))
    ->take(10)
    ->get();

    return $matches;
  }
}
