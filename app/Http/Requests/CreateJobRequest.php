<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class CreateJobRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
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
            'description'=>'max:1000',
            'price'=>'required|numeric|min:0',
            'client_id'=>'required',
            'offer_id'=>'required',

        ];
    }
    public function messages()
    {
        return [

          'required'=> ':attribute duhet te plotesohet.',
          'name.max'=> ':attribute duhet te kete me pak se 100 karaktere.',
          'decription.max'=> ':attribute duhet te kete me pak se 1000 karaktere.',
          'price.numeric'=> ':attribute duhet te jete numer, shembull 1 ose 1.1',
          'price.min'=> ':attribute duhet te jete vlere pozitive, mbi 0.',
          'client_id.required'=> 'Zgjidh klientin ose shto te ri.',
          'offer_id.required'=> 'Zgjidh oferten.',

        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Emri i punes',
            'description'=>'Pershkrimi/Detajet',
            'price'=>'Cmimi',


        ];
    }
}
