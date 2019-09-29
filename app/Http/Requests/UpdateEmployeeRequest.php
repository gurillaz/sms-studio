<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
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





            'name' => 'required|string|max:100',
            'address'=>'required|max:159',
            'position'=>'required|max:100',
            'phone'=>'required|max:20',

            'salary_type' => 'required',
            'salary_amount' => 'required',
            'profile_photo' => 'image',
        ];
    }

    public function messages()
    {
        return [

          'required'=> ':attribute duhet te plotesohet.',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Emri',
            'address' => 'Adresa',
            'phone' => 'Numri i telefonit',
            'salary_type' => 'Lloji i pageses',
            'salary_amount' => 'Shuma e pageses',
            'position' => 'Pozita',
        ];
    }
}
