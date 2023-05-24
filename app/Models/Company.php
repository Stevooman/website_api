<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Company extends Model
{
    use HasFactory;

  /**
   * The primary key associated with the table.
   *
   * @var string
   */
  protected $primaryKey = 'companyId';

  protected $fillable = ['companyName', 'companyAddr', 'active'];

  public static function show(Request $request) {
    $companyId = $request->id;

    
  }
}
