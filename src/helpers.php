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

  $flash = session('flash');
  
  if (null === $type and null === $value) {
    return (empty($flash)) ? false : true;
  } else {
    if (null === $value) {
      if (isset($flash[$type])) {
        $temp = $flash[$type]; // will be destroyed after retrive
        unset($_SESSION['flash'][$type]);
        return $temp;
      } else {
        return '';
      }
    } else {
      return $_SESSION['flash'][$type] = $value;
    }
  }
}

function url($uri, $params = []) {
  $final = rtrim(\Framework\Application::$url_prefix, '/') . $uri;
  
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

function link_to($action, $text, $html = []) {
  if ($action instanceof \TORM\Model) {
    $result = url('/' . strtolower(get_class($action)) . 's/:id', [$action->id]);
  } else {
    $result = url($action);
  }
  $attrs = '';
  foreach ($html as $attr=>$value) {
    $attrs .= " $attr=\"$value\"";
  }

  return "<a href=\"$result\"$attrs>$text</a>";
}