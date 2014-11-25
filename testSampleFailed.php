<?php

require_once( "phptest.php" );

class testController extends PhpTest_TestSuite
{
	function test1()
	{
		TS_ASSERT( 1 == 2 );
		TS_ASSERT_EQUALS( 1, 2 );
		TS_ASSERT_DIFFERS( 2, 2 );

		$a = 1;
		$b =2;
		TS_ASSERT_EQUALS( $a, $b );
	}
	
	function test2()
	{
		TS_ASSERT_DIFFERS( 2, 2 );
	}

	function testPassed()
	{
		TS_ASSERT( 1 == 1 );
	}
	
};

?>