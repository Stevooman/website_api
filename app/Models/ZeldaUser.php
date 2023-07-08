<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use stdClass;

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
  public function showOneByUserId(int $userId)
  {
    $validator = Validator::make(['id' => $userId], [
      'id' => 'required|numeric'
    ]);

    if ($validator->fails()) {
      $e = new \Exception('Incorrect ID format.');
      echo $e->getMessage();
      exit;
    }

    $userInfo = DB::table('zelda_users')->select('id', 'zelda_users.userId', 'firstName', 'lastName', 
      'zGameId', 'title', 'zelda_users.created_at', 'zelda_users.updated_at', 
      'zelda_users.deleted_at')
      ->leftJoin('users', 'users.id', '=', 'zelda_users.userId')
      ->leftJoin('zelda_games', 'zelda_games.id', '=', 'zelda_users.zGameId')
      ->where('zelda_users.userId', $userId)
      ->get();

      if (count($userInfo) > 1) {
        $counter = 0;
        $dataPacket = new stdClass();
        $games = [];

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
        return $dataPacket;
      }

      return $userInfo;
  }
}