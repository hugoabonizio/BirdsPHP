<?php

\Framework\Application::$url_prefix = '/pre/';

class HelperTest extends \PHPUnit_Framework_TestCase {
  function testURL() {
    $this->assertEquals('/pre/aaa', url('/aaa'));
    $this->assertEquals('/pre/photos/1', url('/photos/:id', [1]));
    $this->assertEquals('/pre/photos/1/comment/2', url('/photos/:id/comment/:comment_id', [1, 2]));
    $this->assertEquals('/pre/photos/1', url('/photos/:id', ['id' => 1]));
    $this->assertEquals('/pre/photos/1/comment/2', url('/photos/:id/comment/:comment_id', ['id' => 1, 'comment_id' => 2]));
  }
}