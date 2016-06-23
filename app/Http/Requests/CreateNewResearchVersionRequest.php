<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateNewResearchVersionRequest extends Request
{
    private $form_fields = [
                                  'grantProposal'=>'required|mimes:pdf'
                           ];
    

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
        return $this->form_fields;
    }
}
