<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Requests\Company\CompanyPostRequest;
use App\Http\Requests\Company\CompanyPutRequest;

class CompaniesController extends Controller
{

  public function index() {
    $data = Company::all();
    return response()->json($data);
  }


  public function showOne(Request $request) {
    
    $company = Company::find($request->companyId);
    return response()->json($company);
  }


  public function showAllActive() {
    $companies = Company::where('active', 1)->get();
    return response()->json($companies);
  }


  public function create(CompanyPostRequest $request) {

    try {
      Company::insert($request->all());

    } catch (QueryException $e) {
      throw new \Exception($e->getMessage());
    }
    
    return response()->json(['status' => 'success'], 201);
  }


  public function update(CompanyPutRequest $request) {

    $companyId = $request->companyId;

    try {
      $updated = Company::whereId($companyId)->update($request->all());

    } catch (QueryException $e) {
      throw new \Exception($e->getMessage());
    }

    return response()->json(['updated' => $updated], 200);
  }


  public function delete(Request $request) {
    $companyId = $request->companyId;

    try {
      $deleted = Company::whereId($companyId)->delete();
      
    } catch (QueryException $e) {
      throw new \Exception($e->getMessage());
    }

    return response()->json(['deleted' => $deleted], 200);
  }
}
