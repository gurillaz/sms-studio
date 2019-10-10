<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
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
            'address'=>'required|max:200',
            'date_start'=>'required|date|after:today',
            'description'=>'max:500',
            'duration_hours'=>'required|numeric|max:24|min:1',
            'job_id'=>'sometimes|required|exists:jobs,id',


        ];
    }

    public function messages()
    {
        return [

          'required'=> ':attribute duhet te plotesohet.',
          'date_start.date'=> 'Duhet te jepni daten dhe kohen.',
          'date_start.after'=> 'Data e eventit duhet te jete nje dit pas nga data e tanishme.',
          'duration_hours.numeric'=> ':attribute duhet te jete numer.',
          'duration_hours.max'=> 'Kohezgjatja e eventit duhet te jete nga 1 deri ne 24 ore.',
          'duration_hours.min'=> 'Kohezgjatja e eventit duhet te jete nga 1 deri ne 24 ore.',
          'job_id.exist'=> 'Rikyqu dhe fillo nga fillimi',
          'job_id.required'=> 'Rikyqu dhe fillo nga fillimi',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Emri i eventit',
            'address'=>'Adresa e eventit',
            'date_start'=>'Data e eventit',
            'duration_hours'=>'Kohezgajtja ne ore',

        ];
    }
}
