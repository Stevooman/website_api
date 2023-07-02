<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Http\Requests\User\UserPostRequest;
use App\Http\Requests\User\UserPutRequest;
use Dflydev\DotAccessData\Exception\DataException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class User extends Authenticatable
{
	use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

  /**
   * Constants for the fields names in users table.
   */
  private const FIRSTNAME = 'firstName';
  private const LASTNAME = 'lastName';
  private const EMAIL = 'emailAddr';
  private const USERNAME = 'userName';
  private const PASSWORD = 'password';
  private const VERIFY_EMAIL = 'email_verified_at';
  private const UPDATE_EMAIL = 'email_updated_at';
  private const UPDATE_PASSWORD = 'password_updated_at';
  private const UPDATE_USERNAME = 'username_updated_at';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		self::FIRSTNAME,
		self::LASTNAME,
		self::EMAIL,
		self::USERNAME
	];

	/**
	 * The attributes that should be hidden for serialization.
	 *
	 * @var array<int, string>
	 */
	protected $hidden = [

	];


/**
 * Gets one user's info based on a user ID.
 *
 * @param integer $userId The ID of a user.
 * @return \Illuminate\Support\Collection|array
 */
  public static function showOne(int $userId) 
  {
    $validator = Validator::make(['id' => $userId], [
      'id' => 'required|numeric'
    ]);

    if ($validator->fails()) {
      $e = new \Exception('Incorrect ID format.');
      echo $e->getMessage();
      exit;
    }

    $user = DB::table('users')->select('id', self::FIRSTNAME, self::LASTNAME, 
      self::EMAIL, self::USERNAME, self::VERIFY_EMAIL, 
      self::UPDATE_EMAIL, self::UPDATE_PASSWORD, self::UPDATE_USERNAME, 
      'created_at', 'updated_at', 'deleted_at')
      ->where('id', $userId)
      ->get();

      return $user;
  }



  public static function showByUsernamePassword(string $userName, string $password) 
  {
    $validator = Validator::make(['userName' => $userName], [
      'userName' => 'required|regex:/^\w{4,20}$/'
    ]);

    if ($validator->fails()) {
      $e = new \Exception('Incorrect username format.');
      echo $e->getMessage();
      exit;
    }

    $savedPassword = self::getPassword($userName);

    $user = DB::table('users')->select('id', self::FIRSTNAME, self::LASTNAME, 
      self::EMAIL, self::USERNAME, self::VERIFY_EMAIL, 
      self::UPDATE_EMAIL, self::UPDATE_PASSWORD, self::UPDATE_USERNAME, 
      'created_at', 'updated_at', 'deleted_at')
      ->where('userName', $userName)
      ->get();
    
    if (count($user) > 0) {
      if (password_verify($password, $savedPassword->password)) {
        return $user;
      } 
    }

    return [];
  }



  /**
   * Inserts user data into the users table.
   *
   * @param UserPostRequest $request An HTTP request object that contains
   * input validation rules.
   * @return int Success or failure of the record creation.
   */
  public static function insertUserInfo(UserPostRequest $request) 
  {
    $request['password'] = password_hash($request['password'], PASSWORD_DEFAULT);
    $created = User::insert([
      'firstName' => $request['firstName'],
      'lastName' => $request['lastName'],
      'emailAddr' => $request['emailAddr'],
      'userName' => $request['userName'],
      'password' => $request['password']
    ]);
    return $created;
  }



  /**
   * Updates a user's password. The user record is found by ID.
   *
   * @param UserPutRequest $request An HTTP request object that contains 
   * input validation rules.
   * @return int Success or failure of the update.
   */
  public static function updatePassword(UserPutRequest $request) 
  {
    $password = $request['password'];
    $password = password_hash($password, PASSWORD_DEFAULT);
    $updated = User::whereId($request->userId)->update([
      'password' => $password,
      self::UPDATE_PASSWORD => date('Y-m-d H:i:s')
    ]);
    return $updated;
  }



  /**
   * Updates the email address of a user, found by ID.
   *
   * @param UserPutRequest $request An HTTP request object that contains 
   * input validation rules.
   * @return int Success or failure of the update.
   */
  public static function updateEmail(UserPutRequest $request) 
  {
    $email = $request['emailAddr'];
    $updated = User::whereId($request->userId)->update([
      'emailAddr' => $email,
      self::UPDATE_EMAIL => date('Y-m-d H:i:s')
    ]);
    return $updated;
  }



  /**
   * Updates the username of a user, found by ID.
   *
   * @param UserPutRequest $request An HTTP request object that contains 
   * input validation rules.
   * @return int Success or failure of the update.
   */
  public static function updateUsername(UserPutRequest $request)
  {
    $userName = $request['userName'];
    $updated = User::whereId($request->userId)->update([
      'userName' => $userName,
      self::UPDATE_USERNAME => date('Y-m-d H:i:s')
    ]);
    return $updated;
  }

  /**
   * Soft delete a user record with the given ID.
   *
   * @param int $userId A user ID.
   * @return int Success or failure of the soft delete.
   */
  public static function deleteSystemInfo(int $userId)
  {
    $deleted = User::whereId($userId)->delete();
    return $deleted;
  }



  /**
   * Gets the hashed password for verification of a username.
   *
   * @param string $userName A username.
   * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object|null
   */
  private static function getPassword(string $userName) {
    $password = DB::table('users')->select('password')
      ->where('userName', $userName)
      ->first();

    return $password;
  }
}