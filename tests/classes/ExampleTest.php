<?php
class StackTest extends PHPUnit_Framework_TestCase
{
    public function testExampleReturnsTrueAlwaysReturnsTrue()
    {
        $this->assertEquals(Example::ReturnsTrue(), true);
    }
    
    public function testExampleReturnsFalseAlwaysReturnsFalse()
    {
        $this->assertEquals(Example::ReturnsFalse(), false);
    }
}
?>