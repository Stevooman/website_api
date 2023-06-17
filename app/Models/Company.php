<?php

namespace App\Models;

use App\Http\Requests\Company\CompanyPostRequest;
use App\Http\Requests\Company\CompanyPutRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

/**
 * This class contains constants that contain the column names for the table, 
 * as well as methods that act upon the 'companies' table in the database.
 * These methods include a create, update, and delete function. Additionally, a 
 * array property '$fillable' holds the column names that are mass assignable
 * in a create or update call.
 */
class Company extends Model
{
    use HasFactory, SoftDeletes;

    const TABLE_NAME = 'companies';
    const COL_NAME = 'companyName';
    const COL_ADDR = 'companyAddr';
    const COL_ACTIVE = 'active';

  /**
   * The columns that are mass assignable within the table.
   *
   * @var array
   */
  protected $fillable = ['companyName', 'companyAddr'];
  

  /**
   * Insert a new record into the companies table.
   *
   * @param CompanyPostRequest $request An HTTP request object that contains 
   * the input validation rules.
   * @return int Success or failure of record creation.
   */
  public static function insertCompanyInfo(CompanyPostRequest $request) 
  {
    $created = Company::insert($request->all());

    return $created;
  }


  /**
   * Update a record based on an ID passed in through the request object.
   *
   * @param CompanyPutRequest $request An HTTP request object that contains 
   * the input validation rules.
   * @return int Success or failure of a record update.
   */
  public static function updateCompanyInfo(CompanyPutRequest $request) 
  {
    $companyId = $request->companyId;

    $updated = Company::whereId($companyId)->update($request->all());

    return $updated;
  }


  /**
   * Soft delete a record based on an ID passed in the request.
   *
   * @param Request $request an HTTP request object from the client.
   * @return int Success or failure of the soft deletion.
   */
  public static function deleteCompanyInfo(Request $request)
  {
    $companyId = $request->companyId;

    $deleted = Company::whereId($companyId)->delete();
    
    return $deleted;
  }
}
