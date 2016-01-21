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
  
  function set_flash() {
    $this->flash('error', 'Algum problema!');
    return '';
  }
  function get_flash() {
    return $this->flash('error');
  }
  function empty_flash() {
    return ($this->flash()) ? 'true' : 'false';
  }
}

\Framework\Router::draw(array(
	['GET', '/session', 'session#index'],
  ['GET', '/param', 'session#param'],
  ['GET', '/set_flash', 'session#set_flash'],
  ['GET', '/get_flash', 'session#get_flash'],
  ['GET', '/empty_flash', 'session#empty_flash']
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
    $this->app->route('GET', '/set_flash');
    $this->app->route('GET', '/get_flash');
    $result = ob_get_clean();
		$this->assertEquals('Algum problema!', $result);
    
    // second time
    ob_start();
    $this->app->route('GET', '/get_flash');
    $result = ob_get_clean();
    $this->assertEquals('', $result);
  }
  
  function testTestingFlash() {
    ob_start();
    $this->app->route('GET', '/set_flash');
    $this->app->route('GET', '/empty_flash');
    $result = ob_get_clean();
    $this->assertEquals('true', $result);
    
    ob_start();
    $this->app->route('GET', '/get_flash');
    $this->app->route('GET', '/empty_flash');
    $result = ob_get_clean();
    $this->assertEquals('Algum problema!false', $result);
    
  }
}