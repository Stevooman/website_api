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
  /**
   * Shows all company records.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function index() {
    $data = Company::all();
    return response()->json($data);
  }


  /**
   * Shows one company data based on an ID.
   *
   * @param Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function showOne(Request $request) 
  {
    
    $company = Company::find($request->companyId);
    return response()->json($company);
  }


  /**
   * Shows all companies that are currently active.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function showAllActive() 
  {
    $companies = Company::where(Company::COL_ACTIVE, 1)->get();
    return response()->json($companies);
  }


  /**
   * Adds a new companies record to the database.
   *
   * @param CompanyPostRequest $request An HTTP request object that contains
   * input validation rules.
   * @return \Illuminate\Http\JsonResponse
   */
  public function create(CompanyPostRequest $request) 
  {
    Company::insertCompanyInfo($request);

    return response()->json(['status' => 'success'], 201);
  }


  /**
   * Updates a companies record in the database.
   *
   * @param CompanyPutRequest $request An HTTP request object that contains input validation rules.
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(CompanyPutRequest $request) 
  {
    $updated = Company::updateCompanyInfo($request);

    return response()->json(['updated' => $updated], 200);
  }


  /**
   * Soft deletes a companies record from the database.
   *
   * @param Request $request An HTTP request object.
   * @return \Illuminate\Http\JsonResponse
   */
  public function delete(Request $request) 
  {
    $deleted = Company::deleteCompanyInfo($request);

    return response()->json(['deleted' => $deleted], 200);
  }
}
