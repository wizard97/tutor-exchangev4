<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{

  /**
 * Create the $validator instance from the factory
 *
 * @return \Illuminate\Contracts\Validation\Validator
 */
  public function validator($factory){

  $v = $factory->make($this->all(), $this->container->call([$this, 'rules']), $this->messages(), $this->attributes());

  if(method_exists($this, 'furtherValidation')){
      $this->container->call([$this, 'furtherValidation'], [$v]);
  }

  return $v;
  }
}
