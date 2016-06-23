<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateResearchGrantRequest extends Request
{

    private $form_fields = [
                                  'grantProposal'=>'required|mimes:pdf',
                                  'title_g'=>'required',
                                  'teamMembers'=>'required|numeric',
                                  'researchPlace'=>'required',
                                  'durationList'=>'required',
                                  'duration'=>'required|numeric',
                                  'grantNeeded'=>'required|numeric',
                                  'propDescription'=>'required'

                            ];

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
        
        return  $this->form_fields;

    }
}
