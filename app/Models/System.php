<?php

namespace App\Models;

use App\Http\Requests\System\SystemGetDatesRequest;
use App\Http\Requests\System\SystemPostRequest;
use App\Http\Requests\System\SystemPutRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

/**
 * This class contains constants that contain the column names for the table, 
 * as well as methods that act upon the 'systems' table in the database.
 * These methods include: a 'show one' system, show all systems that were released within a certain date range, and create, update, delete operations. Additionally, a 
 * array property '$fillable' holds the column names that are mass assignable
 * in a create or update call.
 */
class System extends Model
{
	use HasFactory, SoftDeletes;

	const TABLE_NAME = 'systems';
	const COL_NAME = 'name';
	const COL_COMPANY_ID = 'companyId';
	const RELEASE_DATE = 'releaseDate';

  /**
   * The columns that are mass assignable within the table.
   *
   * @var array
   */
	protected $fillable = ['name', 'companyId', 'releaseDate'];

  /**
   * Show one system record info based on a given ID.
   *
   * @param Request $request An HTTP request object
   * @return \Illuminate\Support\Collection
   */
	public static function showOne(Request $request)
	{
		$system = DB::table('systems')->select('systems.id', 'name', 'companyId', 
			'releaseDate', 'companyName', 'companyAddr')
			->leftJoin('companies', 'companies.id', '=', 'systems.companyId')
			->where('systems.id', $request->systemId)
			->get();

		return $system;
	}

  /**
   * Show all systems info that were released within a given date range.
   *
   * @param SystemGetDatesRequest $request HTTP request object that contains 
   * the input validation rules.
   * @return \Illuminate\Support\Collection
   */
	public static function showDateRange(SystemGetDatesRequest $request)
	{
		$system = DB::table(self::TABLE_NAME)->select('id', 'companyId', 'releaseDate', 'name')
			->where('releaseDate', '>=', $request->startDate)
			->where('releaseDate', '<=', $request->endDate)
			->get();

		return $system;
	}


  /**
   * Create a new systems record.
   *
   * @param SystemPostRequest $request HTTP request object that contains 
   * the input validation rules.
   * @return int Success or failure of the insert.
   */
	public static function insertSystemInfo(SystemPostRequest $request)
	{
		$created = System::insert($request->all());
		return $created;
	}


  /**
   * Update an existing systems record with the given ID.
   *
   * @param SystemPutRequest $request HTTP request object that contains 
   * the input validation rules.
   * @return int Success or failure of the update.
   */
	public static function updateSystemInfo(SystemPutRequest $request)
	{
		$updated = System::whereId($request->systemId)->update($request->all());
		return $updated;
	}


  /**
   * Soft delete a systems record with the given ID.
   *
   * @param Request $request HTTP request object
   * @return int Success or failure of the soft delete.
   */
	public static function deleteSystemInfo(Request $request)
	{
		$deleted = System::whereId($request->systemId)->delete();

		return $deleted;
	}
}