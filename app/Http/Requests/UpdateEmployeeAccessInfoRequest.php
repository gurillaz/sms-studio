<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeAccessInfoRequest extends FormRequest
{
    //named errors multiple forms one page
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




            'role' => 'required',
            'password' => 'required|min:6',

        ];
    }

    public function messages()
    {
        return [

            'required' => ':attribute duhet te plotesohet.',
            'unique' => 'Punetori me kete :attribute tashme eshte i regjistruar.',
            'max' => ':attribute duhet te jete :max karaktere.',
            'salary_amount.min' => 'Duhet te jete numer me shume se 1.',
            'min' => ':attribute duhet te te jete me shume se :min karaktere.',
            'numeric' => ':attribute duhet te jete numer.',
            'email' => "Emaili duhet te jete valid."
        ];
    }

    public function attributes()
    {
        return [

            'role' => 'qasja',
            'password' => 'fjalkalimi',
        ];
    }
}
