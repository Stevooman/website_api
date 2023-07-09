<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ZeldaUser;
use App\Http\Requests\User\ZeldaUserPostRequest;

class ZeldaUsersController extends Controller
{
	/**
	 * Show one user's Zelda game info based on a User ID.
	 *
	 * @param Request $request An HTTP request object
	 * @return \Illuminate\Http\JsonResponse
	 */
  public function showOne(Request $request) 
	{
		$zUser = ZeldaUser::showOneByUserId($request->userId);
		return response()->json($zUser);
	}



	/**
	 * Add a new Zelda user record to the database.
	 *
	 * @param ZeldaUserPostRequest $request
	 * @return void
	 */
	public function create(ZeldaUserPostRequest $request) 
	{
		ZeldaUser::insertZeldaUserInfo($request);

		return response()->json(['status' => 'success'], 201);
	}



	public function delete(Request $request) 
	{
		$deleted = ZeldaUser::deleteZeldaUserInfo($request->userId, $request->zGameId);

		return response()->json(['deleted' => $deleted], 200);
	}
}
