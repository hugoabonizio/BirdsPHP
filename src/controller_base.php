<?php
namespace Framework;

class ControllerBase {
	public $_layout = 'application';
	
	function layout($layout) {
		$this->_layout = $layout;
	}
	
	// callbacks
	function before_action() {
	}
	function after_action() {
	}
	
	function redirect($to) {
		header('Location: ' . $to);
	}
	
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
      $this->session('flash', []);
    }
    
    if (null === $type and null === $value) {
      return empty($this->session('flash'));
    } else {
      if (null === $value) {
        $temp = $this->session('flash')[$type]; // destroy after retrive
        $_SESSION['flash'][$type] = '';
        return $temp;
      } else {
        return $_SESSION['flash'][$type] = $value;
      }
    }
	}
}