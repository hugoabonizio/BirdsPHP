<?php
class RouterTest extends \PHPUnit_Framework_TestCase {
	function setUp() {
		\Framework\Router::draw(array(
			['GET', '/', 'welcome#index'],
      ['GET', '/new', 'welcome#new'],
      ['GET', '/show/:id', 'resource#show']
		));
	}
	
	function testAddRoute() {
		$this->assertEquals('welcome#index', \Framework\Router::route('get', '/'));
		$this->assertEquals('welcome#index', \Framework\Router::route('GET', '/'));
    $this->assertEquals('welcome#new', \Framework\Router::route('GET', '/new'));
	}
	
	function test404() {
		$this->assertEquals(404, \Framework\Router::route('GET', '/aaaa'));
    $this->assertEquals(404, \Framework\Router::route('GET', '/a/b'));
	}
  
  function testParams() {
    $this->assertEquals('resource#show', \Framework\Router::route('GET', '/show/2'));
    $this->assertEquals('resource#show', \Framework\Router::route('GET', '/show/10'));
    $this->assertEquals(404, \Framework\Router::route('GET', '/show'));
  }
}
