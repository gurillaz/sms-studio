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





            'name' => 'required|string|max:100',
            'address'=>'required|max:159',
            'position'=>'required|max:100',
            'phone'=>'required|unique:employees|max:20',

            'salary_type' => 'required',
            'salary_month' => 'required',
        ];
    }

    public function messages()
    {
        return [

          'required'=> ':attribute duhet te plotesohet.',
          'phone.unique'=> 'Punetori me kete numer telefoni tashme eshte i regjistruar.',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Emri',
            'address' => 'Adresa',
            'phone' => 'Numri i telefonit',
            'salary_type' => 'Lloji i pageses',
            'salary_month' => 'Pagesa mujore',
            'position' => 'Pozita',
        ];
    }
}
