<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateTaskRatingRequest extends FormRequest
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





            'rating' => 'required|integer|min:0|max:5',




        ];
    }

    public function messages()
    {
        return [

          'required'=> ':attribute duhet te plotesohet.',
          'min'=> ':attribute duhet te jete nga 0 deri ne 5',
          'max'=> ':attribute duhet te jete nga 0 deri ne 5',
          'integer'=> ':attribute duhet te jete numer!',
        
        ];
    }

    public function attributes()
    {
        return [
            'rating' => 'Vlersimi',
        ];
    }
}
