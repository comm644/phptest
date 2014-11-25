<?php
/******************************************************************************
 Copyright (c) 2005 by Alexei V. Vasilyev.  All Rights Reserved.                         
 -----------------------------------------------------------------------------
 Module     : phpTest runner
 File       : phptestrunner.php
 Author     : Alexei V. Vasilyev
 -----------------------------------------------------------------------------
 Description:
******************************************************************************/
require_once( dirname( __FILE__ ) . "/phptest.php" );
require_once( dirname( __FILE__ ). "/tracer.php");

//$PHPTEST_VERBOSE=true;

// test suites define

// end test suites define

$argc = $_SERVER['argc'];
$argv = $_SERVER['argv'];
if ( $argc > 1 ) {
	for( $i=1;  $i <$argc; $i++ ) {
		print( "Loading {$argv[$i]}...\n" );
		require_once( $argv[$i] );
	}
	phpTest::run();
}
else {
	phpTest::run(true);
}


//print_r( get_defined_Vars() );

?>