<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Http\Requests\User\UserPostRequest;
use App\Http\Requests\User\UserPutRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
	use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

  private const COL_FIRSTNAME = 'firstName';
  private const COL_LASTNAME = 'lastName';
  private const COL_EMAIL = 'emailAddr';
  private const COL_USERNAME = 'userName';
  private const COL_PASSWORD = 'password';
  private const COL_VERIFY_EMAIL = 'email_verified_at';
  private const COL_UPDATE_EMAIL = 'email_updated_at';
  private const COL_UPDATE_PASSWORD = 'password_updated_at';
  private const COL_UPDATE_USERNAME = 'username_updated_at';


	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		self::COL_FIRSTNAME,
		self::COL_LASTNAME,
		self::COL_EMAIL,
		self::COL_USERNAME
	];

	/**
	 * The attributes that should be hidden for serialization.
	 *
	 * @var array<int, string>
	 */
	protected $hidden = [
		self::COL_PASSWORD
	];



  public static function showOne(int $userId) 
  {
    $user = DB::table('users')->select('id', self::COL_FIRSTNAME, self::COL_LASTNAME, 
      self::COL_EMAIL, self::COL_USERNAME, self::COL_VERIFY_EMAIL, 
      self::COL_UPDATE_EMAIL, self::COL_UPDATE_PASSWORD, self::COL_UPDATE_USERNAME, 
      'created_at', 'updated_at', 'deleted_at')
      ->where('id', $userId)
      ->get();

      return $user;
  }



  public static function insertUserInfo(UserPostRequest $request) 
  {
    $request['password'] = password_hash($request['password'], PASSWORD_DEFAULT);
    $created = User::insert($request->all());
    return $created;
  }



  public static function updatePassword(UserPutRequest $request) 
  {
    $password = $request['password'];
    $password = password_hash($password, PASSWORD_DEFAULT);
    $updated = User::whereId($request->userId)->update([
      'password' => $password,
      self::COL_UPDATE_PASSWORD => date('Y-m-d H:i:s')
    ]);
    return $updated;
  }



  public static function updateEmail(UserPutRequest $request) 
  {
    $email = $request['emailAddr'];
    $updated = User::whereId($request->userId)->update([
      'emailAddr' => $email,
      self::COL_UPDATE_EMAIL => date('Y-m-d H:i:s')
    ]);
    return $updated;
  }



  public static function updateUsername(UserPutRequest $request)
  {
    $userName = $request['userName'];
    $updated = User::whereId($request->userId)->update([
      'userName' => $userName,
      self::COL_UPDATE_USERNAME => date('Y-m-d H:i:s')
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
}