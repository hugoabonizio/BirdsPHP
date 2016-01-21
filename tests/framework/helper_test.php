<?php

\Framework\Application::$url_prefix = '/pre/';

class Model extends \TORM\Model {}

class HelperTest extends \PHPUnit_Framework_TestCase {
  function testURL() {
    $this->assertEquals('/pre/aaa', url('/aaa'));
    $this->assertEquals('/pre/photos/1', url('/photos/:id', [1]));
    $this->assertEquals('/pre/photos/1/comment/2', url('/photos/:id/comment/:comment_id', [1, 2]));
    $this->assertEquals('/pre/photos/1', url('/photos/:id', ['id' => 1]));
    $this->assertEquals('/pre/photos/1/comment/2', url('/photos/:id/comment/:comment_id', ['id' => 1, 'comment_id' => 2]));
  }
  
  function testLinkTo() {
    $this->assertEquals('<a href="/pre/">Text</a>', link_to('/', 'Text'));
    $model = new Model;
    $model->id = 2;
    $this->assertEquals('<a href="/pre/models/2">Text 2</a>', link_to($model, 'Text 2'));
  }
}