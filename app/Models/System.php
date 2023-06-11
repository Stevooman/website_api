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

class System extends Model
{
	use HasFactory, SoftDeletes;

	const TABLE_NAME = 'systems';
	const COL_NAME = 'name';
	const COL_COMPANY_ID = 'companyId';
	const RELEASE_DATE = 'releaseDate';

	protected $fillable = ['name', 'companyId', 'releaseDate'];


	public static function showOne(Request $request)
	{
		$system = DB::table('systems')->select('systems.id', 'name', 'companyId', 
			'releaseDate', 'companyName', 'companyAddr')
			->leftJoin('companies', 'companies.id', '=', 'systems.companyId')
			->where('systems.id', $request->systemId)
			->get();

		return $system;
	}


	public static function showDateRange(SystemGetDatesRequest $request)
	{
		$system = DB::table(self::TABLE_NAME)->select('id', 'companyId', 'releaseDate', 'name')
			->where('releaseDate', '>=', $request->startDate)
			->where('releaseDate', '<=', $request->endDate)
			->get();

		return $system;
	}



	public static function insertSystemInfo(SystemPostRequest $request)
	{
		$created = System::insert($request->all());
		return $created;
	}



	public static function updateSystemInfo(SystemPutRequest $request)
	{
		$updated = System::whereId($request->systemId)->update($request->all());
		return $updated;
	}



	public static function deleteSystemInfo(Request $request)
	{
		$deleted = System::whereId($request->systemId)->delete();

		return $deleted;
	}
}