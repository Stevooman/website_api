<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class DBException extends Exception
{
  /**
   * Throw error when a database query fails.
   *
   * @param QueryException $e Object 'catch'ed when exception occurs. Contains details to be used
   * for the displayed error message.
   */
  public function __construct(QueryException $e)
  {
    $exceptionMsg = $e->getMessage() . ' on line ' . $e->getLine() . ' in file: ' . $e->getFile();

    if (config('app.debug')) {
      Log::info($e, ['issue' => $e->getMessage()]);
      response()->json([
        'errorCode' => $e->getCode(),
        'errorMsg' => 'Error in querying the database',
        'errorDebug' => $exceptionMsg
      ])
      ->send();
      exit;

    } else {
      
      Log::info($e, ['issue' => $e->getMessage()]);
      response()->json([
        'errorCode' => $e->getCode(),
        'errorMsg' => 'An error occurred in the system. Please try again.'
      ])
      ->send();
      exit;
    }
  }
}
