<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateFileRequest extends FormRequest
{
    // //named errors multiple forms one page
    // protected $errorBag = 'createFile';



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
            'fileable_id' => 'required',
            'fileable_type' => 'required',
            'description' => 'max:1000',
            'file'=>'required|file|max:100000'



        ];
    }

    public function messages()
    {
        return [
            'required'=>':attribute duhet te plotesohet.',
          'fileable_id.required'=> 'Rifreskoje faqen.',
          'fileable_type.required'=> 'Rifreskoje faqen.',
          'file.required'=> 'Ngarko nje skedar.'

        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Emri',
            'description' => 'Pershkrimi',
        ];
    }
}
