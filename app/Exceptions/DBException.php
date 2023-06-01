<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\QueryException;

class DBException extends Exception
{
  public function __construct(QueryException $e)
  {
    if (env('APP_ENV') == 'local') {
      Log::error($e);
      response()->json([
        'error' => 'Error on line ' . $e->getLine() . ' in file ' . $e->getFile(),
        'errorMessage' => $e->getMessage()
      ])->send();
      exit;

    } else {

    }
  }
}
