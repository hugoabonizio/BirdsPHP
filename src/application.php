<?php
namespace Framework;
require_once 'router.php';

class Application {
  public $public_folder = "public/";
  public static $url_prefix = "";
  
	function route($method, $uri) {
    if (substr($uri, 0, strlen("/public/")) == "/public/") { // serve static files
      $this->serve_static($uri);
    } else { // dynamic content
      header('Content-Type: text/html; charset=utf-8');
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
    $url_exploded = explode($public_folder_name, $uri);
    $file = $this->public_folder . end($url_exploded);
    
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    header('Content-Type: ' . finfo_file($finfo, $file) . ';');
    
    echo file_get_contents($file);
  }
}