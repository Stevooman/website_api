<?php

namespace App\Exceptions;

use Exception;


class CustomValidationException extends Exception
{
  /**
   * Throw error when user input validation fails.
   * @param mixed $message Detailed message retrieved from catch block ValidationException
   * @param string $errorText Pop-up window main text
   * @param string $errorDescription Details about why an error is thrown
   */
  public function __construct($message, $errorText, $errorDescription) {
    response()->json([
      'errorText' => $errorText,
      'errorDescription' => $errorDescription,
      'errorDetails' => $message
    ])->send();
    exit;
  }
}
