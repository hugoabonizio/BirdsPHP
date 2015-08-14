<?php
namespace Framework;
require_once 'router.php';

class Application {
	function route($METHOD, $URI) {
		$route = Router::route($METHOD, $URI);
		if (is_numeric($route) and $route == 404) {
			echo 404;
		} else {
			// if it's in format "controller#action"
			if (is_string($route)) {
				$parts = explode('#', $route);
				$controller = $parts[0] . "Controller";
				$action = $parts[1];
				// create a new controller instance
				$instance = new $controller();
				
				// execute before callback
				$instance->before_action();
				
				$result = $instance->$action();
				if ($result === null) {
					// render template
					echo Renderer::render_view($instance, $parts[0], $action);
				} else {
					// render what returned
					echo $result;
				}
				
				// execute after callback
				$instance->after_action();
			}
		}
	}
}