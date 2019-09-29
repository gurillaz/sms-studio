<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateClientRequest extends FormRequest
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
            'city'=>'required|max:100',
            'address'=>'required|max:255',
            'phone'=>'required|unique:clients|max:255',

            'email' => 'required|unique:clients',
        ];
    }

    public function messages()
    {
        return [

          'required'=> ':attribute duhet te plotesohet.',
          'phone.unique'=> 'Klienti me kete numer telefoni tashme eshte i regjistruar.',
          'email.unique'=> 'Klienti me kete email tashme eshte i regjistruar.',
          'email'=> 'Duhet te jete email.'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Emri',
            'city' => 'Qyteti',
            'address' => 'Adresa',
            'phone' => 'Numri i telefonit',
            'email' => 'Emaili',
        ];
    }
}
