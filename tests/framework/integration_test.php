<?php
class TestingController extends \Framework\ControllerBase {
	function index() {
		return "OK!";
	}
}

\Framework\Router::draw(array(
	['GET', '/test1', 'testing#index']
));

class IntegrationTest extends \PHPUnit_Framework_TestCase {
  /**
   * @runInSeparateProcess
   */
  function testIgnoringPrefix() {
    $app = new \Framework\Initializer();
    \Framework\Application::$url_prefix = '/test/';
    ob_start();
    $app->run('/test/test1', 'GET');
    $result = ob_get_clean();
    $this->assertEquals('OK!', $result);
  }
}
