<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeBasicInfoRequest extends FormRequest
{
    //named errors multiple forms one page
    protected $errorBag = 'updateEmployee';
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    public function authorize()
    {
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [



            'name' => 'required|string|max:100|min:3',
            'personal_id' => 'required|max:20|min:6|unique:users,id,'. $this->request->get('id'),
            'address' => 'required|max:200|min:3',
            'email' => 'required|email|unique:users,id|max:40|min:6',
            'phone' => 'required|unique:users,id|max:20|min:6',

        ];
    }

    public function messages()
    {
        return [

            'required' => ':attribute duhet te plotesohet.',
            'unique' => 'Punetori me kete :attribute tashme eshte i regjistruar.',
            'max' => ':attribute duhet te jete :max karaktere.',
            'min' => ':attribute duhet te te jete me shume se :min karaktere.',
            'numeric' => ':attribute duhet te jete numer.',
            'email' => "Emaili duhet te jete valid."
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'emri',
            'personal_id' => 'nr. personal',
            'address' => 'adresa',
            'email' => 'emaili',
            'phone' => 'nr. telfonit',

        ];
    }
}
