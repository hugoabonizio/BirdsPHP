<?php
class SessionController extends \Framework\ControllerBase {
	function index() {
		return $this->session['test1'] = 123;
	}
}

\Framework\Router::draw(array(
	['GET', '/session', 'session#index']
));

class ControllerTest extends \PHPUnit_Framework_TestCase {
	function setUp() {
		$this->app = new \Framework\Application;
	}
	
	function testSessionAction() {
		ob_start();
		$this->app->route('GET', '/session');
		$result = ob_get_clean();
		$this->assertEquals(123, $result);
	}
}