<?php
namespace App\Repositories;
use App\School, App\SchoolClass, App\SchoolSubject;

class SchoolRepository extends BaseRepository
{

  public function _construct(School $school)
  {
    $this->school = $school;
  }
}
