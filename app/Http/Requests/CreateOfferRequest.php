<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateOfferRequest extends FormRequest
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
            'price'=>'required|numeric|min:1',
            'description'=>'max:1000',
            'services'=>'required|array'

        ];
    }

    public function messages()
    {
        return [

          'required'=> ':attribute duhet te plotesohet.',
          'max'=> ':attribute duhet te kete te pakten :max karaktere.',
          'min'=> ':attribute duhet ti caktohet cmimi.Minimumi 1.',
          'numeric'=> ':attribute te jete numer.Minimumi 1.',
          'services.required'=> 'Duhet te zgjidhni te pakten nje sherbim',

        
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Emri',
            'price'=>'Cmimi',
            'description'=>'Detaje shtese',
            'tasks'=>'Detyrat',

        ];
    }
}
