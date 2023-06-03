<?php

namespace App\Models;

use App\Exceptions\DBException;
use App\Http\Requests\Company\CompanyPostRequest;
use App\Http\Requests\Company\CompanyPutRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    const TABLE_NAME = 'companies';
    const COL_NAME = 'companyName';
    const COL_ADDR = 'companyAddr';
    const COL_ACTIVE = 'active';

  /**
   * The primary key associated with the table.
   *
   * @var string
   */
  protected $primaryKey = 'id';

  protected $fillable = ['companyName', 'companyAddr'];
  


  public static function insertCompanyInfo(CompanyPostRequest $request) 
  {
    try {
      $created = DB::table(self::TABLE_NAME)->insert($request->all());

    } catch (QueryException $e) {
      throw new DBException($e);
    }

    return $created;
  }



  public static function updateCompanyInfo(CompanyPutRequest $request) 
  {
    $companyId = $request->companyId;

    try {
      $updated = Company::whereId($companyId)->update($request->all());

    } catch (QueryException $e) {
      throw new DBException($e);
    }

    return $updated;
  }



  public static function deleteCompanyInfo(Request $request)
  {
    $companyId = $request->companyId;

    try {
      $deleted = Company::whereId($companyId)->delete();
      
    } catch (QueryException $e) {
      throw new DBException($e);
    }

    return $deleted;
  }
}
