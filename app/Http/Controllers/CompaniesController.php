<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Requests\Company\CompanyPostRequest;
use App\Http\Requests\Company\CompanyPutRequest;

/**
 * Handles user input and contains CRUD operations that include: Displaying all company records, all active companies, 
 * a single company, as well as standard create, update, and delete operations.
 */
class CompaniesController extends Controller
{

  public function index() {
    $data = Company::all();
    return response()->json($data);
  }


  public function showOne(Request $request) 
  {
    
    $company = Company::find($request->companyId);
    return response()->json($company);
  }


  public function showAllActive() 
  {
    $companies = Company::where(Company::COL_ACTIVE, 1)->get();
    return response()->json($companies);
  }


  public function create(CompanyPostRequest $request) 
  {
    Company::insertCompanyInfo($request);

    return response()->json(['status' => 'success'], 201);
  }


  public function update(CompanyPutRequest $request) 
  {
    $updated = Company::updateCompanyInfo($request);

    return response()->json(['updated' => $updated], 200);
  }


  public function delete(Request $request) 
  {
    $deleted = Company::deleteCompanyInfo($request);

    return response()->json(['deleted' => $deleted], 200);
  }
}
