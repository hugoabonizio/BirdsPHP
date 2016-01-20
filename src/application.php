<?php
namespace Framework;
require_once 'router.php';

class Application {
  public $public_folder = "public/";
  public static $url_prefix = "";
  
	function route($method, $uri) {
    if (substr($uri, 0, strlen("/public/")) == "/public/") { // serve static files
      echo $this->serve_static($uri);
    } else { // dynamic content
      $route = Router::route($method, $uri);
      if (is_numeric($route) and $route == 404) {
        echo 404;
      } else {
        // if it's in format "controller#action"
        if (is_string($route)) {
          Router::extract_params($method, $uri);

          $parts = explode('#', $route);
          $controller = $parts[0] . "Controller";
          $action = $parts[1];
          // create a new controller instance
          $instance = new $controller();
          
          // inject some config variables
          $instance->url_prefix = self::$url_prefix;
          $instance->public_folder = $this->public_folder;

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
  
  private function serve_static($uri) {
    $folders = explode('/', $this->public_folder);
    $public_folder_name = $folders[count($folders) - 2];
    return file_get_contents($this->public_folder . end(explode($public_folder_name, $uri)));
  }
}