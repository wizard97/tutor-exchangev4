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
  // Create the factory
  $v = $factory->make($this->all(), $this->container->call([$this, 'rules']), $this->messages(), $this->attributes());
  // If the class is extended, then call the function
  if(method_exists($this, 'extendValidator')){
      $this->container->call([$this, 'extendValidator'], [$v]);
  }

  return $v;
  }
}
