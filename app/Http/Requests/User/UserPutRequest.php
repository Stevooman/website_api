<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserPutRequest extends FormRequest
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
      'emailAddr' => 'nullable|email|max:30',
      'userName' => 'nullable|string|regex:' . self::USERNAME_REGEX,
      'password' => 'nullable|string|regex:' . self::PASSWORD_REGEX
		];
	}



  public function messages(): array
  {
    return [
      'userName' => 'The username must only contain letters, numbers, and underscores.',
      'password' => 'Password must contain an uppercase letter, lowercase letter, at least one number, and at least one special character.'
    ];
  }
}