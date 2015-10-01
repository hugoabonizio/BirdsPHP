<?php
namespace Framework;

class Router {
	static private $_routes;
	
  // format ['GET', '/', 'welcome#index']
	static function draw($routes) {
		foreach ($routes as $route) {
      if ($route[1][0] == '/') {
        $route[1] = substr($route[1], 1);
      }
      $regex_route = '/^' . self::convert_params(str_replace('/', '\/', $route[1])) . '$/';
			self::$_routes[$regex_route][strtoupper($route[0])] = $route[2];
		}
	}
	
	static function route($method, $uri) {
    $uri = substr($uri, 1); // after first / ("/about", for example)
    foreach (array_keys(self::$_routes) as $route) {
      if (preg_match($route, $uri)) {
			  return self::$_routes[$route][strtoupper($method)];
      }
    }
		return 404;
	}
  
  static private function convert_params($string) {
    return preg_replace("/:(.*)/", "(?<aaa>[a-z-A-B0-9]+)", $string);
  }
}