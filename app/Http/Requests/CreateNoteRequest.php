<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateNoteRequest extends FormRequest
{
    //named errors multiple forms one page
    protected $errorBag = 'createNote';



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
            'body'=>'max:1000',
            'noteable_id'=>'required',
            'noteable_type'=>'required',

        ];
    }

    public function messages()
    {
        return [

          'notebale_id.required'=> 'Rifreskoje faqen.',
          'neteable_type.required'=> 'Rifreskoje faqen.',
          'required'=> ':attribute duhet te plotesohet.',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Emri',
            'body' => 'Pershkrimi',
        ];
    }
}
