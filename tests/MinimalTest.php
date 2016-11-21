<?php
 
use Maduser\Minimal\Minimal;
 
class MinimalTest extends PHPUnit_Framework_TestCase {
 
  public function testMinimalHasPhpCode()
  {
    $minimal = new Minimal;
    $this->assertTrue($minimal->hasPhpCode());
  }
 
}
