<?php

namespace App\Models;

use App\Http\Requests\Company\CompanyPostRequest;
use App\Http\Requests\Company\CompanyPutRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    const TABLE_NAME = 'companies';
    const COL_NAME = 'companyName';
    const COL_ADDR = 'companyAddr';
    const COL_ACTIVE = 'active';

  protected $fillable = ['companyName', 'companyAddr'];
  


  public static function insertCompanyInfo(CompanyPostRequest $request) 
  {
    $created = Company::insert($request->all());

    return $created;
  }



  public static function updateCompanyInfo(CompanyPutRequest $request) 
  {
    $companyId = $request->companyId;

    $updated = Company::whereId($companyId)->update($request->all());

    return $updated;
  }



  public static function deleteCompanyInfo(Request $request)
  {
    $companyId = $request->companyId;

    $deleted = Company::whereId($companyId)->delete();
    
    return $deleted;
  }
}
