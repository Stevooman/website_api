<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\User\UserPostRequest;
use App\Http\Requests\User\UserPutRequest;

class UsersController extends Controller
{
	/**
	 * Shows all users records.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
  public function index()
	{
		$users = User::all();
		return response()->json($users);
	}



	/**
	 * Show one user first name, last name, and email based on an ID
	 *
	 * @param Request $request An HTTP request object
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function showOne(Request $request)
	{
		$user = User::showOne($request->userId);
		return response()->json($user);
	}



	/**
	 * Adds a new user record to the database.
	 *
	 * @param UserPostRequest $request An HTTP request object that contains 
	 * input validation rules.
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function create(UserPostRequest $request)
	{
		User::insertUserInfo($request);

		return response()->json(['status' => 'success'], 201);
	}



	/**
	 * Updates an existing user's password.
	 *
	 * @param UserPutRequest $request An HTTP request object that contains 
	 * the input validation rules.
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function updatePassword(UserPutRequest $request)
	{
		$updated = User::updatePassword($request);

		return response()->json(['updated' => $updated], 200);
	}



  /**
   * Updates an existing user's email.
   *
   * @param UserPutRequest $request An HTTP request object that contains 
   * the input validation rules.
   * @return \Illuminate\Http\JsonResponse
   */
  public function updateEmail(UserPutRequest $request)
  {
    $updated = User::updateEmail($request);

    return response()->json(['updated' => $updated], 200);
  }



  /**
   * Updates an existing user's username.
   *
   * @param UserPutRequest $request An HTTP request object that contains 
   * the input validation rules.
   * @return \Illuminate\Http\JsonResponse
   */
  public function updateUsername(UserPutRequest $request)
  {
    $updated = User::updateUsername($request);

    return response()->json(['updated' => $updated], 200);
  }



	/**
	 * Soft deletes one user record in the database.
	 *
	 * @param Request $request An HTTP request object.
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function delete(Request $request)
	{
		$deleted = User::deleteSystemInfo($request->userId);

		return response()->json(['deleted' => $deleted], 200);
	}
}
