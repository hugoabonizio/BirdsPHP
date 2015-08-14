<?php
class CallbackController extends \Framework\ControllerBase {
	function index() {
		return "...";
	}
	
	function before_action() {
		echo "BEFORE ";
	}
	function after_action() {
		echo " AFTER";
	}
}
\Framework\Router::draw(array(
	['GET', '/callbacks', 'callback#index']
));

class CallbackTest extends \PHPUnit_Framework_TestCase {
	function setUp() {
		$this->app = new \Framework\Application;
	}
	
	function testBeforeAction() {
		ob_start();
		$this->app->route('GET', '/callbacks');
		$rendered = ob_get_clean();
		$this->assertEquals('BEFORE ... AFTER', $rendered);
	}
}