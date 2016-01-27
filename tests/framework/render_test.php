<?php
class TestingController extends \Framework\ControllerBase {
	function index() {
		return "OK!";
	}
  
  function user() {
    $this->render('another_view');
    return $this->_view;
  }
}
\Framework\Router::draw(array(
	['GET', '/test1', 'testing#index'],
	['GET', '/test2', 'testing#user']
));

class RenderTest extends \PHPUnit_Framework_TestCase {
	function setUp() {
		$this->app = new \Framework\Application;
	}
  
  /**
   * @runInSeparateProcess
   */
	function testRenderText() {
		ob_start();
		$this->app->route('GET', '/test1');
		$rendered = ob_get_clean();
		$this->assertEquals('OK!', $rendered);
	}
  
  /**
   * @runInSeparateProcess
   */
  function testChangingViewName() {
    ob_start();
		$this->app->route('GET', '/test2');
		$rendered = ob_get_clean();
		$this->assertEquals('another_view', $rendered);
  }
}