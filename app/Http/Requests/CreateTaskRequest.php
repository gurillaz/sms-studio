<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateTaskRequest extends FormRequest
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
            'payment_sum'=>'required',
            'description'=>'max:1000',
            'status'=>'required|max:1000',
            'inventory'=>'required|array',



        ];
    }

    public function messages()
    {
        return [

          'required'=> ':attribute duhet te plotesohet.',
          'max'=> ':attribute duhet te kete te pakten :max karaktere.',
          'inventory.array'=> ':attribute duhet te jete 1 ose me shume pajisje',
        
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Emri',
            'payment_sum'=>'Pagesa',
            'description'=>'Pershkrimi',
            'inventory'=>'Paisjet',

        ];
    }
}
