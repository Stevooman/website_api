<?php

namespace App\Http\Requests\System;

use Illuminate\Foundation\Http\FormRequest;

class SystemGetDatesRequest extends FormRequest
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
			'startDate' => 'required|date_format:Y-m-d',
			'endDate' => 'required|date_format:Y-m-d'
		];
	}
}