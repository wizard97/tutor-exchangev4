<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProposeSchoolRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    /**
     * Apply further validation on the $validator
     *
     *
     */
    public function furtherValidation($validator)
    {
      $validator->after(function($validator) {
          if (false) {
              $validator->errors()->add('field', 'Something is wrong with this field!');
          }
      });
    }
}
