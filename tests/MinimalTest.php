<?php
 
use Maduser\Minimal\Minimal;
 
class MinimalTest extends PHPUnit_Framework_TestCase {
 
  public function testMinimalHasPhpCode()
  {
    $nacho = new Minimal;
    $this->assertTrue($nacho->hasPhpCode());
  }
 
}
