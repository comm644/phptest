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
require_once( "phptest.php" );


// test suites define

require_once( "testSamplePassed.php" );
require_once( "testSampleFailed.php" );

// end test suites define



phpTest::run();

?>