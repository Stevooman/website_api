<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CompaniesController extends Controller
{
  public function __construct(Request $request) {

  }


  public function index(Request $request) {
    $data = Company::all();
    return response()->json($data);
  }


  public function showOne(Request $request) {

    $company = Company::find($request->companyId);
    return response()->json($company);
  }


  public function create(Request $request) {
    $validator = Validator::make($request->all(), [
      'companyName' => 'required|string|max:30',
      'companyAddr' => 'required|string|max:100',
      'active' => 'nullable|integer|min:0|max:1'
    ]);

    if ($validator->fails()) {
      $ex = new ValidationException($validator);
      return response()->json($ex->validator->errors()->getMessages());
    }

    $company = new Company;
    $company->companyName = $request->companyName;
    $company->companyAddr = $request->companyAddr;
    if ($request->active) {
      $company->active = $request->active;
    }

    $company->save();
    return response()->json(['status' => 'success']);
  }


  public function update(Request $request) {

  }


  public function delete(Request $request) {

  }
}
