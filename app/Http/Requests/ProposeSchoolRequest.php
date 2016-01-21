<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Repositories\Proposals\SchoolProposal;

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
            'uid',
            'school_id',
            'to_delete',
            'school_name',
            'zip_id'
        ];
    }

    /**
     * Apply further actions on the $validator
     *
     *
     */
    public function extendValidator($validator)
    {
      $validator->after(function($validator){

      });
    }
}
