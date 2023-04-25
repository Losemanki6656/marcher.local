<?php

namespace App\SuperAdmin\Http\Requests\Api\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Validation\Rule;

class BindCardRequest extends FormRequest
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
        $rules = [
            'transaction_id' => 'required',
            'verification_code' => 'required|min:6',
            'plan_id' => 'required',
            'plan_type' => 'required',
        ];

        return $rules;
    }
}
