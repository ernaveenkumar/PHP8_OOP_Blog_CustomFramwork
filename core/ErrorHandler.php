<?php
namespace Core;

class ErrorHandler{

  public static function handleException(\Throwable $exception){
    //1. Log the error
    static::logError($exception);


    //example php bin/load_schama.php
    if(php_sapi_name() === 'cli'){
      static::renderCliError($exception);
    }else{
      static::renderErrorPage($exception);
    }

  }

  private static function logError(\Throwable $exception){

    $logMessage = static::formatErrorMessage(
      $exception,
      "[%s] Error: [0m %s: %s in %s on line %d \n"
    );

    error_log($logMessage, 3, __DIR__ . '/../logs/error.log');
  }
  private static function renderCliError(\Throwable $exception) : void {

    $isDebug = App::get('config')['app']['debug'] ?? false;

    if($isDebug){
      $errorMessage = static::formatErrorMessage(
        $exception,
        "\033[31m[%s] Error:\033[0m %s: %s in %s on line %d \n"
      );

      $trace = $exception->getTraceAsString();
    }else{
      $errorMessage = "\033[31m An Unexpected error occured. Please check error log for details.\003[0m\n";
      $trace = "";
    }

    fwrite(STDERR, $errorMessage);
    if($trace){
     fwrite(STDERR, "\nStack trace:\n$trace\n");
    }
    // This is an exit code for CLI programs
    // 0 = evethig is fine
    //1 = error
    exit(1);
    
  }
  private static function renderErrorPage(\Throwable $exception) : void {

    $isDebug = App::get('config')['app']['debug'] ?? false;

    if($isDebug){
      $errorMessage = static::formatErrorMessage(
        $exception,
        "[%s] Error: %s: %s in %s on line %d \n"
      );

      $trace = $exception->getTraceAsString();
    }else{
      $errorMessage = " An Unexpected error occured. Please check error log for details.\n";
      $trace = "";
    }
    http_response_code(500);
    echo View::render('errors/500', [
      'errorMessage' => $errorMessage,
      'trace' => $trace,
      'isDebug' => $isDebug
    ], 'layouts/main');
    exit();
  }




  public static function handleError($level, $message, $file,$line){

    $exception = new \ErrorException($message, 0, $level, $line);

    self::handleException($exception);
  }


  private static function formatErrorMessage(\Throwable $exception, string $format) : string {

    return sprintf(
      $format,
      date('Y-m-d H:i:s'),
      get_class($exception),
      $exception->getMessage(),
      $exception->getFile(),
      $exception->getLine()
    );
  }
}