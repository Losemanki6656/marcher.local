<?php

namespace App\SuperAdmin\Http\Requests\Api\PaymentSettings;

use Illuminate\Foundation\Http\FormRequest;

class PaymoUpdateRequest extends FormRequest
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
			'paymo_api_key'    => 'required',
			'paymo_api_secret'    => 'required',
			'paymo_store_id'    => 'required',
			'paymo_terminal_id'    => 'required',
			'paymo_status'    => 'required',
		];

		return $rules;
	}
}
