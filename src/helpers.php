<?php
function session($name = null, $value = null) {
  if (null === $name) {
    return $_SESSION;
  } else {
    if (null === $value) {
      return $_SESSION[$name];
    } else {
      return $_SESSION[$name] = $value;
    }
  }
}

function params($name = null, $value = null) {
  if (null === $name) {
    return $_REQUEST;
  } else {
    if (null === $value) {
      return $_REQUEST[$name];
    } else {
      return $_REQUEST[$name] = $value;
    }
  }
}

function flash($type = null, $value = null) {
  if (!isset($_SESSION['flash'])) {
    session('flash', []);
  }

  if (null === $type and null === $value) {
    $flash = session('flash');
    return (empty($flash)) ? true : false;
  } else {
    if (null === $value) {
      $temp = session('flash')[$type]; // destroy after retrive
      $_SESSION['flash'][$type] = '';
      return $temp;
    } else {
      return $_SESSION['flash'][$type] = $value;
    }
  }
}

function url($uri, $params = []) {
  $final = \Framework\Application::$url_prefix . trim($uri, '/');
  
  if (array_values($params) === $params) { // pass params in array
    foreach ($params as $param) {
      $final = preg_replace('/:(\w+)/', $param, $final, 1);
    }
  } else {
    foreach ($params as $param=>$value) {
      $final = str_replace(":$param", $value, $final);
    }
  }
  return $final;
}