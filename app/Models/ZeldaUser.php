<?php

namespace App\Models;

use App\Http\Requests\User\ZeldaUserPostRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use stdClass;

/**
 * This class contains constants for the column names for the table, 
 * as well as methods that act upon the 'zelda_users' table in the database.
 * These methods include create, delete, and show functions. Additionally, a 
 * array property '$fillable' holds the column names that are mass assignable
 * in a create or update call.
 */
class ZeldaUser extends Model
{
	use HasFactory, SoftDeletes;

  private const TABLE_NAME = 'zelda_users';
  private const USER_ID = 'userId';
  private const GAME_ID = 'zGameId';

  /**
   * The columns that are mass assignable within the table.
   *
   * @var array
   */
  protected $fillable = [self::USER_ID, self::GAME_ID];




  /**
   * Gets one zelda user info based on a user ID.
   *
   * @param integer $userId The ID of a user.
   * @return \Illuminate\Support\Collection|array|stdClass
   */
  public static function showOneByUserId(int $userId)
  {
    $validator = Validator::make(['id' => $userId], [
      'id' => 'required|numeric'
    ]);

    if ($validator->fails()) {
      $e = new \Exception('Incorrect ID format.');
      echo $e->getMessage();
      exit;
    }

    $userInfo = DB::table('zelda_users')->select('zelda_users.id AS zeldaUserId', 'zelda_users.userId', 'firstName', 'lastName', 
      'zGameId', 'title', 'zelda_users.created_at', 'zelda_users.updated_at', 
      'zelda_users.deleted_at')
      ->leftJoin('users', 'users.id', '=', 'zelda_users.userId')
      ->leftJoin('zelda_games', 'zelda_games.id', '=', 'zelda_users.zGameId')
      ->where('zelda_users.userId', $userId)
      ->get();

    $dataPacket = new stdClass();
    $games = [];
    if (count($userInfo) > 0) {
      $counter = 0;
      

      foreach ($userInfo as $u) {
        if ($counter == 0) {
          $dataPacket->userId = $u->userId;
          $dataPacket->firstName = $u->firstName;
          $dataPacket->lastName = $u->lastName;
        }

        array_push($games, (object) [
          'zGameId' => $u->zGameId,
          'title' => $u->title,
          'created_at' => $u->created_at,
          'updated_at' => $u->updated_at,
          'deleted_at' => $u->deleted_at
        ]);
        $counter++;
      }
      
      $dataPacket->games = $games;
    }

    return $dataPacket;
  }



  /**
   * Insert user's zelda game data into the zelda_users table.
   *
   * @param ZeldaUserPostRequest $request An HTTP request object that contains 
   * all of the input validation info.
   * @return int
   */
  public static function insertZeldaUserInfo(ZeldaUserPostRequest $request) 
  {
    $created = ZeldaUser::insert([
      'userId' => $request['userId'],
      'zGameId' => $request['zGameId']
    ]);

    return $created;
  }



  /**
   * Soft deletes one zelda user's info based on a given userId and zGameId.
   *
   * @param integer $userId A User ID.
   * @param integer $zGameId A zelda game ID.
   * @return int
   */
  public static function deleteZeldaUserInfo(int $userId, int $zGameId) 
  {
    $validator = Validator::make(['id' => $userId, 'zGameId' => $zGameId], [
      'id' => 'required|numeric',
      'zGameId' => 'required|numeric'
    ]);

    if ($validator->fails()) {
      $e = new \Exception('Incorrect ID format.');
      echo $e->getMessage();
      exit;
    }

    $deleted = ZeldaUser::where('userId', $userId)->where('zGameId', $zGameId)->delete();
    return $deleted;
  }
}
