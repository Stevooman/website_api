<?php

namespace App\Models;

use App\Http\Requests\Company\CompanyPostRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Company extends Model
{
    use HasFactory, SoftDeletes;

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
      $newCompany = DB::table('companies')->insert($request->all());
    } catch (QueryException $e) {
      
    }
  }
}
