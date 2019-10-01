<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreatePaymentRequest extends FormRequest
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
            'amount' => 'required|numeric',
            'from' => 'required|string|max:100',
            'to' => 'required|string|max:100',
            'type' => 'required',
            'status' => 'required',
            'paymentable_id' => 'sometimes|required',
            'paymentable_type' => 'sometimes|required',
            'category' => 'sometimes|required|max:100',
            'description' => 'max:1000',
 



        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute duhet te plotesohet.',
            'paymentable_id.required' => 'Rifreskoje faqen.',
            'paymentable_type.required' => 'Rifreskoje faqen.',
            'amount.required' => ':attribute duhet te caktohet!',
            'type.required' => 'Rifresko faqen!',
            'status.required' => 'Rifresko faqen!'

        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Emri',
            'from' => 'Dhenesi',
            'to' => 'Marresi',
            'description' => 'Detajet',
            'amount' => 'Shuma',
            'category' => 'Kategoria',
        ];
    }
}
