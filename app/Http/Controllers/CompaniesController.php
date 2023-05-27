<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomValidationException;
use App\Models\Company;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
    try {
      $validData = $this->validate($request, [
        'companyName' => 'required|string|max:30',
        'companyAddr' => 'required|string|max:100',
        'active' => 'nullable|integer|min:0|max:1',
      ]);
    } catch (ValidationException $e) {
      $messages = $e->validator->errors()->getMessages();
      throw new CustomValidationException(
        $messages,
        'Input Error',
        'One or more fields did not pass validation.'
      );
    }

    try {
      Company::insert($validData);

    } catch (QueryException $e) {
      throw new \Exception($e->getMessage());
    }
    
    return response()->json(['status' => 'success']);
  }


  public function update(Request $request) {

    $companyId = $request->companyId;
    $companyName = $request->companyName;
    $companyAddr = $request->companyAddr;
    $active = $request->active;

    try {
      $this->validate($request, [
      'companyName' => 'nullable|string|max:30',
      'companyAddr' => 'nullable|string|max:100',
      'active' => 'nullable|integer|min:0|max:1',
      ]);
    } catch (ValidationException $e) {
      $messages = $e->validator->errors()->getMessages();
      throw new CustomValidationException(
        $messages,
        'Input Error',
        'One or more fields did not pass validation.'
      );
    }

    // Build data array to update the model
    $updateData = $this->getUpdateArray($companyName, $companyAddr, $active);

    try {
      $updated = Company::where('companyId', $companyId)->update($updateData);

    } catch (QueryException $e) {
      throw new \Exception($e->getMessage());
    }

    return response()->json(['updated' => $updated]);
  }


  public function delete(Request $request) {
    $companyId = $request->companyId;
  }


  /**
   * Build an array of parameters used to update the database.
   * @param mixed $name The company name
   * @param mixed $address The company address
   * @param int $active 1 = active, 2 = not active
   * @return array
   */
  private function getUpdateArray($name = '', $address = '', int $active = null) {
    $updateData = [];
    if ($name) {
      $updateData['companyName'] = $name;
    }
    if ($address) {
      $updateData['companyAddr'] = $address;
    }
    if ($active != null) {
      $updateData['active'] = $active;
    }

    return $updateData;
  }
}
