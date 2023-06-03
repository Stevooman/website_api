<?php

namespace App\Models;

use App\Exceptions\DBException;
use App\Http\Requests\Company\CompanyPostRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    const ATTR_NAME = 'companyName';
    const ATTR_ADDRESS = 'companyAddr';
    const ATTR_ACTIVE = 'active';

  /**
   * The primary key associated with the table.
   *
   * @var string
   */
  protected $primaryKey = 'id';

  protected $fillable = ['companyName', 'companyAddr'];


  public static function showAll()
  {
    try {
      $companyData = Company::all();
    } catch (QueryException $e) {
      throw new DBException($e);
    }
    return $companyData;
  }
  

  public static function showOne(Request $request)
  {
    try {
      $company = Company::find($request->companyId);
    } catch (QueryException $e) {
      throw new DBException($e);
    }
    return $company;
  }



  public static function insertCompanyInfo(CompanyPostRequest $request) 
  {
    try {
      $newRecord = DB::table('companies')->insert($request->all());
    } catch (QueryException $e) {
      throw new DBException($e);
    }
    return $newRecord;
  }
}
