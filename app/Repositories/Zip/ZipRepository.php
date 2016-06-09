<?php
namespace App\Repositories\Zip;

use App\Repositories\BaseRepository;

use App\Models\Zip\Zip;

class ZipRepository extends BaseRepository implements ZipRepositoryContract
{

  public function __construct(Zip $model)
  {
    $this->model = $model;
  }

  public function findBySearch($query)
  {
    $keys = preg_split("/[\s,.]+/", trim(urldecode($query)), NULL, PREG_SPLIT_NO_EMPTY);

    $search = new $this->model;

    foreach ($keys as $key)
    {
      $search->where(function ($query) use ($key){
        $query
        ->orWhere('zips.zip_code', 'LIKE', '%'.$key.'%')
        ->orWhere('zips.city', 'LIKE', '%'.$key.'%')
        ->orWhere('zips.state_prefix', 'LIKE', '%'.$key.'%');
      });
    }

    $matches = $search->select('zips.*', \DB::raw("CONCAT_WS(', ', CONCAT(UCASE(LEFT(city, 1)),LCASE(SUBSTRING(city, 2))), CONCAT_WS(' ',state_prefix, zips.zip_code)) as address"))
    ->take(10)
    ->get();

    return $matches;
  }

  public function find($zip, $city)
  {
      $search = new $this->model;
      return $search->where("zip_code", $zip)->where('city', $city)->firstOrFail();
  }

}
