<?php

namespace App\Http\Controllers;

use App\Http\Requests\System\SystemPutRequest;
use App\Http\Requests\System\SystemGetDatesRequest;
use App\Http\Requests\System\SystemPostRequest;
use Illuminate\Http\Request;
use App\Models\System;

class SystemsController extends Controller
{
	public function index() 
	{
		$systems = System::all();
		return response()->json($systems);
	}



	public function showOne(Request $request)
	{
		$system = System::showOne($request);
		return response()->json($system);
	}



	public function showDateRange(SystemGetDatesRequest $request)
	{
		$systems = System::showDateRange($request);
		return response()->json($systems);
	}



	public function create(SystemPostRequest $request)
	{
		System::insertSystemInfo($request);

		return response()->json(['status' => 'success'], 201);
	}



	public function update(SystemPutRequest $request)
	{
		$updated = System::updateSystemInfo($request);

		return response()->json(['updated' => $updated], 200);
	}



	public function delete(Request $request)
	{
		$deleted = System::deleteCompanyInfo($request);

		return response()->json(['deleted' => $deleted], 200);
	}
}