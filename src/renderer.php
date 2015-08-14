<?php
namespace Framework;

class Renderer {
	static function render_view($instance, $controller, $action) {
		if (file_exists('app/views/' . $controller . '/' . $action . '.php')) {
			extract(get_object_vars($instance));
			ob_start();
			include 'app/views/' . $controller . '/' . $action . '.php';
			$yield = ob_get_clean();
			if (file_exists('app/views/layouts/' . $instance->_layout . '.php')) {
				include 'app/views/layouts/' . $instance->_layout . '.php';
			}
		} else {
			echo 'vish';
		}
	}	
}