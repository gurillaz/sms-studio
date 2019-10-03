<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateInventoryRequest extends FormRequest
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



            'name' => 'required|string|max:100|min:3',
            'type' => 'required|string|max:100|min:3',
            'purchase_date' => 'sometimes|date',
            'supplier' => 'sometimes|string|max:100|min:3',
            'price' => 'sometimes|numeric|min:1',
            'serial' => 'sometimes|string|max:50|min:2',
            'description' => 'sometimes|max:1000|min:3',
            'status' => 'sometimes|required|min:1',

        ];
    }

    public function messages()
    {
        return [

            'required' => ':attribute duhet te plotesohet.',
            'max' => ':attribute duhet te jete :max karaktere.',
            'min' => ':attribute duhet te te jete me shume se :min karaktere.',
            'numeric' => ':attribute duhet te jete numer.',
            'date' => ':attribute duhet te jete date.',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Emri',
            'type' => 'Lloji',
            'purchase_date' => 'Data e blerjes',
            'supplier' => 'Furnitori',
            'price' => 'Cmimi',
            'serial' => 'Numri serik',
            'description' => 'Te dhenat shtese',
            'status' => 'Statusi',


        ];
    }
}