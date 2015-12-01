<?php
class RouterTest extends \PHPUnit_Framework_TestCase {
	function setUp() {
		\Framework\Router::draw([
			['GET', '/', 'welcome#index'],
      ['GET', '/new', 'welcome#new'],
      ['GET', '/show/:id', 'resource#show'],
      ['GET', '/resource/:id/edit', 'resource#edit'],
      ['RESOURCES', 'users']
		]);
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
    $this->assertEquals('resource#edit', \Framework\Router::route('GET', '/resource/10/edit'));
  }
  
  function testGetParams() {
    \Framework\Router::extract_params('GET', '/resource/10/edit/');
    $this->assertEquals('10', $_REQUEST['id']);
  }
  
  function testResources() {
    $this->assertEquals('users#index', \Framework\Router::route('GET', '/users'));
    $this->assertEquals('users#add', \Framework\Router::route('GET', '/users/add'));
    $this->assertEquals('users#create', \Framework\Router::route('POST', '/users'));
    $this->assertEquals('users#edit', \Framework\Router::route('GET', '/users/1/edit'));
    $this->assertEquals('users#update', \Framework\Router::route('POST', '/users/1'));
    $this->assertEquals('users#destroy', \Framework\Router::route('POST', '/users/1/destroy'));
  }
}
