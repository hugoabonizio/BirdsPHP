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
		header('Location: ' . url($to));
	}
	
	function session($name = null, $value = null) {
		return session($name, $value);
	}
  
  function params($name = null, $value = null) {
		return params($name, $value);
	}
  
  function flash($type = null, $value = null) {
		return flash($type, $value);
	}
}