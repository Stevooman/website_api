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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
	use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'firstName',
		'lastName',
		'emailAddr',
		'userName'
	];

	/**
	 * The attributes that should be hidden for serialization.
	 *
	 * @var array<int, string>
	 */
	protected $hidden = [
		'password'
	];



  public static function showOne(int $userId) 
  {
    $user = DB::table('users')->select('id', 'firstName', 'lastName', 
      'emailAddr', 'userName', 'email_verified_at', 'created_at', 
      'updated_at', 'deleted_at')
      ->where('id', $userId)
      ->get();

      return $user;
  }



  public static function insertUserInfo(UserPostRequest $request) 
  {
    $created = User::insert($request->all());
    return $created;
  }



  public static function updateUserInfo(UserPutRequest $request) 
  {
    $updated = User::whereId($request->userId)->update($request->all());
    return $updated;
  }
}