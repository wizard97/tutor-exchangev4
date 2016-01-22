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
            'proposal_type' => 'required|in:create,edit,delete|string',
            'address' => 'required_unless:proposal_type,delete|string',
            'school_name' => 'required_unless:proposal_type,delete|string',
            'school_search' => 'required_unless:proposal_type,create|string',
        ];
    }

    /**
     * Add custom messages
     *
     * @return array
     */
    public function messages()
    {
        return [
            'address.required_unless' => 'The address field is required unless deleting.',
            'school_name.required_unless' => 'The school name field is required unless deleting.',
            'school_search.required_unless' => 'We need to know the school you are trying to edit/delete.',
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
