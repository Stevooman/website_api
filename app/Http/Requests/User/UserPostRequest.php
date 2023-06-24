<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UserPostRequest extends FormRequest
{
  /**
   * Username should contain only alpha-numeric and underscore characters, and should 
   * be between 4 and 20 characters long.
   */
  private const USERNAME_REGEX = '/^\w{4,20}$/';

  /**
   * Password should be a minimum 6 maxiumum 60 characters and contain at least 1 uppercase, 
   * lowercase, number, and special character.
   */
  private const PASSWORD_REGEX = '/^.*(?=.{6,60})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%@&*()=\'\";,.\/-]).*$/';

  /**
   * First name should contain letters and spaces only, maximum of 20 characters.
   */
  private const FIRSTNAME_REGEX = '/^[a-zA-Z ]{1,20}$/';

  /**
   * Last name should contain letters, spaces, apostrophes only, maximum of 25 characters.
   */
  private const LASTNAME_REGEX = '/^[a-zA-Z \']{1,25}$/';
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
			'firstName' => 'required|string|regex:' . self::FIRSTNAME_REGEX,
			'lastName' => 'required|string|regex:' . self::LASTNAME_REGEX,
			'emailAddr' => 'required|email|max:30',
			'userName' => 'required|string|regex:' . self::USERNAME_REGEX,
      'password' => 'required|string|regex:' . self::PASSWORD_REGEX
		];
	}



  public function messages(): array 
  {
    return [
      'firstName' => 'First name must only contain letters.',
      'lastName' => 'Last name must only contain letters.',
      'userName' => 'The username must only contain letters, numbers, and underscores.',
      'password' => 'Password must contain an uppercase letter, lowercase letter, at least one number, and at least one special character.'
    ];
  }
}