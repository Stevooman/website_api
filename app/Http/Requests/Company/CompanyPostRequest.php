<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validation rules for user input POST requests sent to the Companies API.
 */
class CompanyPostRequest extends FormRequest
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
			'companyName' => 'required|string|max:30',
			'companyAddr' => 'required|string|max:100',
			'active' => 'nullable|integer|min:0|max:1'
		];
	}
}