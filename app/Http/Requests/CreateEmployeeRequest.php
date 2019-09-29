<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateEmployeeRequest extends FormRequest
{
    //named errors multiple forms one page
    //    protected $errorBag = 'createClient';
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    /**
     * The URI to redirect to if validation fails.
     *
     * @var string
     */
    //    protected $redirect = $this->url();

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
            'personal_id' => 'required|unique:users|max:20|min:6',
            'address' => 'required|max:200|min:3',
            'email' => 'required|email|unique:users|max:40|min:6',
            'phone' => 'required|unique:users|max:20|min:6',
            'employee_type' => 'required',
            'position' => 'required|max:100|min:6',
            'salary_type' => 'required',
            'salary_amount' => 'numeric|min:1',
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
            'name' => 'emri',
            'personal_id' => 'nr. personal',
            'address' => 'adresa',
            'email' => 'emaili',
            'phone' => 'nr. telfonit',
            'employee_type' => 'lloji i puntorit',
            'position' => 'pozita e puntorit',
            'salary_type' => 'lloji i pageses',
            'salary_amount' => 'shuma',
            'role' => 'qasja',
            'password' => 'fjalkalimi',
        ];
    }
}
