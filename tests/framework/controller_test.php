<?php
class SessionController extends \Framework\ControllerBase {
	function index() {
		return $this->session['test1'] = 123;
	}
  
  function param() {
    $this->params['test1'] = 666;
    return $this->params['test1'];
  }
}

\Framework\Router::draw(array(
	['GET', '/session', 'session#index'],
  ['GET', '/param', 'session#param']
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
  
  function testParamAction() {
		ob_start();
		$this->app->route('GET', '/param');
		$result = ob_get_clean();
		$this->assertEquals(666, $result);
	}
  
  function testStaticFiles() {
    $this->app->public_folder = dirname(__FILE__) . '/public/';
    ob_start();
		$this->app->route('GET', '/public/style.css');
		$result = ob_get_clean();
		$this->assertEquals('body { background: black; }', $result);
  }
}