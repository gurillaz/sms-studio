<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeWorkInfoRequest extends FormRequest
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




            'employee_type' => 'required',
            'position' => 'required|max:100|min:6',
            'salary_type' => 'required',
            'salary_amount' => 'numeric|min:1',

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

            'employee_type' => 'lloji i puntorit',
            'position' => 'pozita e puntorit',
            'salary_type' => 'lloji i pageses',
            'salary_amount' => 'shuma',

        ];
    }
}
