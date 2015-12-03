<?php
class SessionController extends \Framework\ControllerBase {
	function index() {
    $this->session('test1', 123);
		return $this->session('test1');
	}
  
  function param() {
    $this->params('test1', 666);
    return $this->params('test1');
  }
  
  function message() {
    $this->flash('error', 'Deu erro!');
//     var_dump($_SESSION);
    return $this->flash('error');
  }
}

\Framework\Router::draw(array(
	['GET', '/session', 'session#index'],
  ['GET', '/param', 'session#param'],
  ['GET', '/message', 'session#message']
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
  
  function testStaticFilesInsideFolder() {
    $this->app->public_folder = dirname(__FILE__) . '/public/';
    ob_start();
		$this->app->route('GET', '/public/js/script.js');
		$result = ob_get_clean();
		$this->assertEquals('alert(666);', $result);
  }
  
  function testFlashMessage() {
    ob_start();
    $this->app->route('GET', '/message');
    $result = ob_get_clean();
		$this->assertEquals('Deu erro!', $result);
  }
}