<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateFileRequest extends FormRequest
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
            'description' => 'max:1000',
            'file'=>'sometimes|required|file|max:100000'



        ];
    }

    public function messages()
    {
        return [
            'required'=>':attribute duhet te plotesohet.',

          'file.required'=> 'Ngarko nje skedar.',
          'file.max'=> 'Madhesia e fajllit nuk mund te jete me shume se 10Mb.'
          

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
