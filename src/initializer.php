<?php
namespace Framework;

if (!isset($_SESSION)) {
  session_start();
}

include_once 'application.php';

// autoloading models/controllers
spl_autoload_register(function ($name) {
  foreach(['models', 'controllers'] as $folder) {
    if (file_exists("app/$folder/" . strtolower($name) . '.php')) {
      include_once "app/$folder/" . strtolower($name) . '.php';
      return;
    }
  }
});

header('Content-Type: text/html; charset=utf-8');

class Initializer extends Application {
  function __construct() {
    $this->loadFramework();
    $this->loadControllers();
    $this->loadModels();
    $this->loadRoutes();
  }
  
  function loadFramework() {
    $files = scandir(dirname(__FILE__));
    foreach ($files as $file) {
      if ($file != '.' and $file != '..') {
        include_once dirname(__FILE__) . '/' . $file;
      }
    }
  }
  
  function loadModels() {
    if (is_dir('app/models')) {
      $files = scandir('app/models');
      foreach ($files as $file) {
        if ($file != '.' and $file != '..') {
          include_once 'app/models/' . $file;
        }
      }
    }
  }
  
  function loadControllers() {
    if (is_dir('app/controllers')) {
      $files = scandir('app/controllers');
      foreach ($files as $file) {
        if ($file != '.' and $file != '..') {
          include_once 'app/controllers/' . $file;
        }
      }
    }
  }
  
  function loadRoutes() {
    if (file_exists('config/routes.php')) {
      include 'config/routes.php';
    }
  }
  
  function run($uri, $method) {
    $url_prefix = \Framework\Application::$url_prefix;
    if (substr($uri, 0, strlen($url_prefix)) == $url_prefix) {
      $uri = substr($uri, strlen($url_prefix));
    }
    $path = strtok($uri, '?');
    if ($path[0] != '/') $path = '/' . $path;
    parent::route($method, $path);
  }
}