<?php
class RouterTest extends \PHPUnit_Framework_TestCase {
	function setUp() {
		\Framework\Router::draw(array(
			['GET', '/', 'welcome#index']
		));
	}
	
	function testAddRoute() {
		$this->assertEquals('welcome#index', \Framework\Router::route('get', '/'));
		$this->assertEquals('welcome#index', \Framework\Router::route('GET', '/'));
	}
	
	function test404() {
		$this->assertEquals(404, \Framework\Router::route('GET', '/aaaa'));
	}
}
