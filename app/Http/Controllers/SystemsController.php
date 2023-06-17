<?php

namespace App\Http\Controllers;

use App\Http\Requests\System\SystemPutRequest;
use App\Http\Requests\System\SystemGetDatesRequest;
use App\Http\Requests\System\SystemPostRequest;
use Illuminate\Http\Request;
use App\Models\System;

/**
 * Handles client input and displays database data as JSON objects. Contains CRUD 
 * operations that should all systems, one based on an ID, all systems released 
 * within a date range, and create, update, delete endpoints.
 */
class SystemsController extends Controller
{
  /**
   * Shows all systems records.
   *
   * @return \Illuminate\Http\JsonResponse
   */
	public function index() 
	{
		$systems = System::all();
		return response()->json($systems);
	}


  /**
   * Show one system data based on an ID
   *
   * @param Request $request An HTTP request object
   * @return \Illuminate\Http\JsonResponse
   */
	public function showOne(Request $request)
	{
		$system = System::showOne($request);
		return response()->json($system);
	}


  /**
   * Shows all systems released between a given date range.
   *
   * @param SystemGetDatesRequest $request A request object that contains
   * the input validation rules.
   * @return \Illuminate\Http\JsonResponse
   */
	public function showDateRange(SystemGetDatesRequest $request)
	{
		$systems = System::showDateRange($request);
		return response()->json($systems);
	}


  /**
   * Adds a new system record to the database.
   *
   * @param SystemPostRequest $request An HTTP request object that contains 
   * input validation rules.
   * @return \Illuminate\Http\JsonResponse
   */
	public function create(SystemPostRequest $request)
	{
		System::insertSystemInfo($request);

		return response()->json(['status' => 'success'], 201);
	}


  /**
   * Updates an existing systems record.
   *
   * @param SystemPutRequest $request An HTTP request object that contains 
   * the input validation rules.
   * @return \Illuminate\Http\JsonResponse
   */
	public function update(SystemPutRequest $request)
	{
		$updated = System::updateSystemInfo($request);

		return response()->json(['updated' => $updated], 200);
	}


  /**
   * Soft deletes one systems record in the database.
   *
   * @param Request $request An HTTP request object.
   * @return \Illuminate\Http\JsonResponse
   */
	public function delete(Request $request)
	{
		$deleted = System::deleteSystemInfo($request);

		return response()->json(['deleted' => $deleted], 200);
	}
}