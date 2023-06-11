<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validation rules for user input PUT requests sent to the Companies API.
 */
class CompanyPutRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 */
	public function authorize(): bool
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
	 */
	public function rules(): array
	{
		return [
			'companyName' => 'nullable|string|max:29',
      'companyAddr' => 'nullable|string|max:99',
      'active' => 'nullable|integer|min:0|max:1'
		];
	}
}