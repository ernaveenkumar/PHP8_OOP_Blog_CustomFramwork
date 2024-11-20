<?php

namespace Core;

use RuntimeException;
class  View{
  public static function render(string $template, array $data = [], string $layout = null):string{
    
    $content = static::renderTemplate($template, $data);
    return static::renderLayout($layout, $data, $content);
  }



  protected static function renderTemplate(string $template, array $data):string {

    //So essentially this means you have an array that is an associative array.
    //So keys from this array become variable names and values become the values of those new variables.
    extract($data);
    $path = dirname(__DIR__). "/app/Views/$template.php";
    //var_dump($path); die;
    if(!file_exists($path)){
      throw new RuntimeException("Error: Template file not found: $path");
    }
    ob_start();
    require $path;
    return ob_get_clean();
  }
  protected static function renderLayout(?string $template, array $data, string $content):string {

    if(null === $template){
      return $content;
    }

    //So essentially this means you have an array that is an associative array.
    //So keys from this array become variable names and values become the values of those new variables.
    extract([...$data, 'content' => $content]);
    $path = dirname(__DIR__). "/app/Views/$template.php";

    if(!file_exists($path)){
      throw new RuntimeException("Error: Template file not found: $path");
    }
    ob_start();
    require $path;
    return ob_get_clean();
  }
}