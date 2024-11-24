<?php
namespace Core;
class Router{

  // public function __construct(){
  //   echo "works";
  // }

  protected array $routes = [];
  public function add(string $method, string $uri, string $controller):void{

    $this->routes[] = [
      'method' => $method,
      'uri' => $uri,
      'controller' => $controller
    ];
  }

  public function dispatch(string $uri, string $method):string{
    
    $route = $this->findRoute($uri, $method);
    if(!$route){
      //var_dump($route); die();
      return $this->notFound();
    }

    // PotController@index
    //Post Controller@start
    [$controller, $action] = explode('@', $route['controller']);
    return $this->callAction($controller, $action, $route['params']);
  }

  //if not route could be found return null
  public function findRoute(string $uri, string $method): ?array{
    
    foreach($this->routes as $route){
     
      $params = $this->matchRoute($route['uri'], $uri);
      if($params !== null && $route['method'] === $method){
        return [...$route, 'params' =>$params]; 
      }
       
    }
    return null;
  }

  protected function matchRoute(string $routeUri, string $requestUri):?array{

    $params = [];
    //var_dump($routeUri, $requestUri);
    $routeSegments = explode('/', trim($routeUri,'/'));
    $requestSegments = explode('/', trim($requestUri, '/'));
    
    if(count($routeSegments) !== count($requestSegments)){
      //var_dump($routeSegments, $requestSegments); die('matchRoute null');
      return null;
    }

    foreach($routeSegments as $index =>$routeSegment){
      if(str_starts_with($routeSegment,'{') && str_ends_with($routeSegment,'}')){
        $params[trim($routeSegment,'{}')] = $requestSegments[$index];
      }elseif($routeSegment !== $requestSegments[$index]){
        return null;
      }
    }
    return $params;
  }

  //action is a method of controller
  //Now I'm adding two slashes because one slash is an escape character for special characters.
  protected function callAction(string $controller, string $action, array $params): string{


    //Start with the app prefix. Then we go with controller namespace again slash, and only then we've got the actual controller class name, and I can directly use this controller variable here.So this would be our class name.
    $controllerClass = "App\\Controllers\\$controller";

    // I can create a new class in PHP by using a $controllerClass variable.
    //action is a method of a controller.That's why I can also use the action variable in place of the method name.
    //Again, PHP will resolve the value of this variable, and whatever the name is, it will try to find
    //such method in this created object and run it.

    return (new $controllerClass)->$action(...$params);
  }

  public function notFound():void{
    http_response_code(404);
    echo "404 Not Found";
    exit;
  }

}