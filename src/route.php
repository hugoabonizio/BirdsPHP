<?php
namespace Framework;

class Route {
  public $action;
  public $pattern;
  
  function __construct($action, $pattern) {
    $this->action = $action;
    $this->pattern = $pattern;
  }
}