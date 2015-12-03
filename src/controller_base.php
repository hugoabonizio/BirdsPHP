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
	
	function session($name = '', $value = '') {
		if (empty($name)) {
			return $_SESSION;
		} else {
      if (empty($value)) {
			  return $_SESSION[$name];
      } else {
        return $_SESSION[$name] = $value;
      }
		}
	}
  
  function params($name = '', $value = '') {
		if (empty($name)) {
			return $_REQUEST;
		} else {
      if (empty($value)) {
			  return $_REQUEST[$name];
      } else {
        return $_REQUEST[$name] = $value;
      }
		}
	}
}