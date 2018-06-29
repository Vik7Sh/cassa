<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;


class TransactionPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'categorie_id'          => 'required|numeric',
            'type_transaction_id'   => 'required|numeric',
            'account_id'            => 'required|numeric',
            'summ'                  => 'required|min:1|numeric',
        ];
    }

    public function failedValidation(Validator $validator){
        $this->validator = $validator;
    }
}
