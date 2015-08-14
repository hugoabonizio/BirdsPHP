<?php
namespace Framework;

class Router {
	static private $_routes;
	
	static function draw($routes) {
		foreach ($routes as $route) {
// 			if (is_string($to)) {
//  				$to = explode('#', $to);
//  				$controller = $to[0];
//  				$action = $to[1];
				
				
// 				// controller#action pattern
// 			} elseif (is_callable($to)) {
// 				// bind direct a lambda function
// 			}
			self::$_routes[$route[1]][strtoupper($route[0])] = $route[2];
		}
	}
	
	static function route($method, $uri) {
		if (array_key_exists($uri, self::$_routes)) {
			return self::$_routes[$uri][strtoupper($method)];
		} else {
			return 404;
		}
	}
}