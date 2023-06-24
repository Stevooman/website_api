<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UserPostRequest extends FormRequest
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
   * Password Should contain at least one capital letter, number, and special character.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
	 */
	public function rules(): array
	{
		return [
			'firstName' => 'required|string|max:20',
			'lastName' => 'required|string|max:25',
			'emailAddr' => 'required|email|max:30',
			'userName' => 'required|string',
      'password' => 'required|
                     string|
                     regex:/^.*(?=.{6,})(?=.*[a-zA-Z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/'
		];
	}
}