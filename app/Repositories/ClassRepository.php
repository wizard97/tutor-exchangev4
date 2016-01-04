<?php
namespace App\Repositories;
use App\School, App\SchoolClass, App\SchoolSubject;

class ClassRepository extends BaseRepository
{

  public function _construct(SchoolClass $cl)
  {
    $this->class = $cl;
  }
}
