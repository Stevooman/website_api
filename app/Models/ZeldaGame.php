<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ZeldaGame extends Model
{
	use HasFactory, SoftDeletes;

	private const SYSTEM_ID = 'systemId';
	private const TITLE = 'title';

	/**
   * The columns that are mass assignable within the table.
   *
   * @var array
   */
  protected $fillable = [self::SYSTEM_ID, self::TITLE];
}