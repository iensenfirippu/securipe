<?php
include_once('src/Classes/Example.php');

class ExampleTest extends PHPUnit_Framework_TestCase
{
	public function testMakeSureTestsAreRun()
	{
		$this->assertTrue(true);
	}

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