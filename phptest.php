<?php
/******************************************************************************
 Module     : phpTest. cxxTest clone for PHP
 File       : phptest.php
 Author     : Alexei V. Vasilyev
 -----------------------------------------------------------------------------
 Description: cxxTest clone for PHP. see samples.
******************************************************************************/

  //show information about running test
global $PHPTEST_VERBOSE;
$PHPTEST_VERBOSE=false;


define( 'PHPTEST_EXCEPTIONS', version_compare(PHP_VERSION, '5.0.0', '>='));

class PhpTest_AssertException extends Exception
{
}

class PhpTest_TestSuite
{
	function setUp()
	{
	}
	function tearDown()
	{
	}
	function suiteStart()
	{
	}
	function suiteEnd()
	{
	}
	
	//new methods
	function suiteSetUp()
	{
		$this->suiteStart();
	}
	function suiteTearDown()
	{
		$this->suiteEnd();
	}

	/**
	 * Assert that $x == $y
	 * @param mixed $x  X argument
	 * @param mixed $y  Y argument
	 * @param string $m  message which will be display onm assertion fail.
	 * @return bool true on success.
	 */
	function assertEquals( $x, $y, $m=null)
	{
		TS_ASSERT_EQUALS($x, $y, $m);
	}
	/**
	 * Assert that $x != $y
	 * @param mixed $x  X argument
	 * @param mixed $y  Y argument
	 * @param string $m  message which will be display onm assertion fail.
	 * @return bool true on success.
	 */
	function assertDiffers( $x, $y, $m=null)
	{
		TS_ASSERT_DIFFERS($x, $y, $m);
	}
	/**
	 * Assert that $x != $y
	 * @param mixed $x  X argument
	 * @param mixed $y  Y argument
	 * @param string $m  message which will be display onm assertion fail.
	 * @return bool true on success.
	 */
	function assertNotEquals( $x, $y, $m=null)
	{
		$this->assertDiffers($x, $y, $m);
	}

	/**
	 * Assert that $x > $y
	 * @param mixed $x  X argument
	 * @param mixed $y  Y argument
	 * @param string $m  message which will be display onm assertion fail.
	 * @return bool true on success.
	 */
	function assertGreateThen($x, $y, $m=null)
	{
        TS_ASSERT_GREATER($x, $y, $m);
    }
	/**
	 * Assert that $x >= $y
	 * @param mixed $x  X argument
	 * @param mixed $y  Y argument
	 * @param string $m  message which will be display onm assertion fail.
	 * @return bool true on success.
	 */
    function assertGreateOrEquals( $x, $y, $m=null )
    {
        TS_ASSERT_GREATER_OR_EQUALS($x, $y, $m);
    }
	/**
	 * Assert that $x < $y
	 * @param mixed $x  X argument
	 * @param mixed $y  Y argument
	 * @param string $m  message which will be display onm assertion fail.
	 * @return bool true on success.
	 */
    function assertLessThen( $x, $y, $m=null)
    {
        TS_ASSERT_LESS_THEN($x, $y, $m);
    }
	/**
	 * Assert that $x <= $y
	 * @param mixed $x  X argument
	 * @param mixed $y  Y argument
	 * @param string $m  message which will be display onm assertion fail.
	 * @return bool true on success.
	 */
    function assertLessOrEquals( $x, $y, $m=null)
    {
        TS_ASSERT_LESSER_OR_EQUALS($x, $y, $m);
    }


	/**
	 * assert that $x contains $y
	 *
	 * @param string $x X argument
	 * @param string $y Y argument
	 * @param string $msg   message which will be displayed on assertion fail.
	 */
	function assertContains( $x, $y, $msg=null ) {
		TS_ASSERT_CONTAINS($x, $y, $msg);
	}
	
};
define( "CLASS_PhpTest_TestSuite", get_class( new PhpTest_TestSuite() ));

class PhpTest_Output
{
	var $nMessage = 0;
	var $isVerboseMode = false;

	function PhpTest_Output()
	{
		if ( array_key_exists( "argv", $_SERVER )) {
			define( "CR", "\n" );
			define( "PARA", "" );
			define( "B1", "" );
			define( "B2", "" );
		}
		else {
			define( "PARA", "<pre>" );
			define( "CR", "<br>" );
			define( "B1", "<b>" );
			define( "B2", "</b>" );
		}

		global $PHPTEST_VERBOSE;
		$this->isVerboseMode = $PHPTEST_VERBOSE;
	}
	
	function printmsg( $msg, $endl = CR )
	{
		print( "$msg$endl" );
	}
	
	function begin( $total )
	{
		$this->printmsg( sprintf( PARA . "Running %d tests", $total), "" );
	}
	
	function end( $total, $nFailed )
	{

		if ( $nFailed == 0 ) {
			if ( $this->isVerboseMode) {
				$this->printmsg( CR. "Success rate: 100%", CR . CR);
			}
			else {
				$this->printmsg( "OK");
			}
			return;
		}
		else {
			$this->printmsg( CR. CR. "$nFailed of $total failed");
		}
		$this->printmsg(  sprintf( "Success rate: %d%%", (($total - $nFailed ) / $total ) * 100 ) );
	}

	function printError( $file, $line, $suite, $test, $msg )
	{
		$this->trace( $file, $line, $suite, $test, $msg, "Assertion failed" );
	}
	
	function trace( $file, $line, $suite, $test, $msg, $alert="Trace" )
	{
		if ( $this->nMessage ==0 ) {
			$this->printmsg( CR . "In $suite::$test");
		}
		$this->printmsg( "$file:$line: $alert: $msg");
		
		$this->nMessage++;
	}

	function testBegin( $suite, $test )
	{
		$this->nMessage = 0;
		if ( $this->isVerboseMode) {
			$this->printmsg( CR . "$suite::$test: ", "" );
		}
		//dbg( "\n$suite::$test: " );
	}
	
	function testPassed()
	{
		if ( $this->isVerboseMode) {
			$this->printmsg( "OK" , "");
		}
		else {
			print( "." );
		}
	}

	function testFailed()
	{
		print( "F" );
	}

	public function testIgnored($suite, $test)
	{
		if ( $this->isVerboseMode) {
			$this->printmsg( CR . "$suite::$test: IGNORED", "" );
		}
		else {
			$this->printmsg( "Ignored: $suite::$test" );
		}
	}

	function gettype( $var )
	{
		if ( is_string( $var ) ) return "string";
		if ( is_bool( $var ) ) return "bool";
		if ( is_int( $var ) ) return "int";
		if ( is_null( $var ) ) return "null";
		return gettype( $var );
	}
	function getReportExpect( $op, $x, $y, $msg=null )
	{
		$xtype=  $this->gettype( $x );
		$ytype = $this->gettype( $y );

		$x = var_export($x, true);
		$y = var_export($y, true);
		
		$display = "x $op y";
		$display .= (( $msg ) ? "\nMessage : $msg" : "") . CR;
		$display .=  "Expect x ($xtype):<$x>" . CR;
		$display .=  "   Was y ($ytype):<$y>";
		return( $display );
	}
	function getReportExpectNot( $op, $x, $y, $msg=null )
	{
		$xtype=  $this->gettype( $x );
		$ytype = $this->gettype( $y );

		$x = var_export($x, true);
		$y = var_export($y, true);

		$display = "x $op y";
		$display .= (( $msg ) ? "\nMessage : $msg" : "") . CR;
		$display .=  "Expect not x($xtype):<$x>" . CR;
		$display .=  "       Was y($ytype):<$y>";
		return( $display );
	}
	function getReportXY( $op, $x, $y, $msg=null )
	{
		$x = var_export($x, true);
		$y = var_export($y, true);


		$display = "x $op y";
		$display .= (( $msg ) ? "\nMessage : $msg" : "") . CR;
		$display .=  " x:<$x>" . CR;
		$display .=  " y:<$y>";
		return( $display );
	}
};

class phpTest
{
	var $total = 0;     //totalTests
	var $testCount =0 ; //nFailedAsserts (for current test)
	var $nFailed = 0;   //nFailedTests (total)

	var $output = null;
	
	var $suites  = array();
	var $tests   = array();
	var $ignoredTests = array();

	//current test
	var $suiteName;
	var $testName;

	var $verboseOutput = false;
	
	function PhpTest()

	{
		$this->output = new PhpTest_Output();
		global $PHPTEST_VERBOSE;
		$this->verboseOutput = $PHPTEST_VERBOSE;


	}

	function getTestNames( $args)
	{
		$result = array();
		foreach( $args as $name ) {
			if( strncmp( $name, "xtest", 5 ) == 0 ) {
				$this->ignoredTests[] = $name;
			}
			if( strncmp( $name, "test", 4 ) != 0 ) continue;
			array_push( $result, $name );
		}
		return( $result );
	}
	
	function getSuiteNames( $args )
	{
		$result = array();
		foreach( $args as $name ) {
			if( strncmp( $name, "test", 4 ) != 0 ) continue;
			if ( get_parent_class( new $name ) != CLASS_PhpTest_TestSuite ) continue;
			array_push( $result, $name );
		}
		return( $result );
	}
	
	function scanTests()
	{
		$this->suites  =  PhpTest::getSuiteNames( get_declared_classes() );

		foreach( $this->suites as $suite ) {
			$tests  =  PhpTest::getTestNames( get_class_methods( $suite ) );
			foreach( $this->ignoredTests as $name ) {

				$this->output->testIgnored($suite, $name );
			}
			$this->ignoredTests = array();
			
			$this->tests[ $suite ]= $tests; //??? for future use
			$this->total += count( $tests );
		}
	}
	
	function doSuite( $suite )
	{
		//suite
		$methods = get_class_methods( $suite );
		$tests  =  PhpTest::getTestNames( $methods );

		$obj = new $suite;
		$obj->suiteSetUp();
		foreach ( $tests as $test ) {
			$this->enterTest( $test );
				
			$obj->setUp($test);
			//print( "<li>$suite::$test<br>");
			if ( PHPTEST_EXCEPTIONS) {
				try {
					$obj->$test();
				}
				catch( PhpTest_AssertException $e){
					
				}
			}
			else {
				$obj->$test();
			}

			
			$obj->tearDown();

			$this->leaveTest();
		}
		$obj->suiteTearDown();
		unset( $obj );
	}

	function doWorld()
	{
		$this->scanTests();
		
		$this->enterWorld();
		//world
		foreach( $this->suites as $suite ) {
			$this->enterSuite( $suite );
			$this->doSuite( $suite );
			$this->leaveSuite();
		}

		$this->leaveWorld();
		
	}

	function enterWorld()
	{
		$this->output->begin( $this->total );
	}
	function leaveWorld()
	{
		$this->output->end( $this->total, $this->nFailed );
	}

	function enterSuite( $suiteName )
	{
		$this->suiteName = $suiteName;
	}
	
	function leaveSuite()
	{
		
	}

	function enterTest( $testName )
	{
		$this->testName = $testName;
		$this->testCount = 0;
		$this->output->testBegin( $this->suiteName, $this->testName );
	}

	function leaveTest()
	{
		if ( $this->testCount == 0 ) {
			$this->output->testPassed();
		}
		else {
			$this->nFailed++;
			$this->output->testFailed();
		}
	}
	function getClass( $stackInfo )
	{
		if ( array_key_exists( "class", $stackInfo) ) return $stackInfo["class"];
		return "__global__";
	}

	function getTrace( $trace )
	{
		while( $trace[0]['file'] == __FILE__ ){
			array_shift( $trace );
		};
		
		$source1 = $trace[0];
		$source2 = $trace[1];
		
		$val = array(
			"file" => $source1["file"],
			 "line" => $source1["line"],
			 "class" => phpTest::getClass($source2),
			 "function" => $source2["function"],
			 "from_file" => $source2["file"],
			 "from_line" => $source2["line"],
			);
		return( $val );
	}
	
	function assertionFailed( $msg )
	{
		$this->testCount++;
		$trace = PhpTest::getTrace( debug_backtrace() );
		
		$this->output->printError( $trace["file"], $trace["line"], $this->suiteName, $this->testName, $msg); //$trace["class"], $trace["function"]
		//reuse validators support

		$this->printTrace();
		$this->output->printmsg( "" );

		if ( PHPTEST_EXCEPTIONS) {
			throw new PhpTest_AssertException("assertion failed");
		}
		return( true );
	}
	function printTrace()
	{
		$bt = debug_backtrace();
		$this->output->printmsg( "Trace:" );
		for( $i=0; $i < count( $bt ); $i++ ) {
			$point = &$bt[$i];
			$next = &$bt[$i+1];
			if ( !array_key_exists( "class", $next ) ) $next["class"]=null;
			if ( $point["file"] === __FILE__ ) continue;

			$this->output->printmsg( sprintf( "%s:%d: %s::%s()", $point[ "file" ], $point[ "line" ], $next["class"], $next['function'] ) );
			$pclass = get_parent_class( $next["class"] );
			if ( $pclass === CLASS_PhpTest_TestSuite && strpos($next['function'], "test")===0 ) {
				break;
			}
		}
	}

	function trace( $msg, $alert="Trace", $level=0)
	{
		$trace = PhpTest::getTrace( debug_backtrace() );
		$this->output->trace( $trace["file"], $trace["line"], $trace["class"], $trace["function"], $msg, $alert);
	}

	
	function isTestFailed()
	{
		return( $this->testCount != 0 );
	}

	static function doScanFiles()
	{
		//print( "PhpTest autoload : " );
		
		if ($handle = opendir('.')) {
			/* This is the correct way to loop over the directory. */
			while (false !== ($file = readdir($handle))) {
				$file = trim( $file );
				if ( strncmp( $file, "test", 4 ) == 0 &&
					substr( $file, strlen($file) - 4 ) == ".php" ) {
					//print ("$file\n " );
					require_once( $file );
				}
			}

			closedir($handle);
		}
		else {
			print "Error: can't open directory .";
		}
	}

	/** Main function.  static
	 */
	static function run( $signScanFiles = false )
	{
		if ( $signScanFiles ) {
			PhpTest::doScanFiles();
		}
		
		global $_phpTestObject;
		$_phpTestObject = new PhpTest;
		$_phpTestObject->doWorld();
	}
};

function TS_ASSERT( $arg, $msg=null )
{
	global $_phpTestObject;
	if ( $arg == FALSE ) return( $_phpTestObject->assertionFailed( "$arg" . (( $msg ) ? "\n\tMessage: " . $msg : "")) );
	return( false );
}

function TS_ASSERT_EQUALS( $x, $y, $msg=null )
{
	global $_phpTestObject;
	if ( (is_array( $x ) || is_object( $x )) || ( is_array( $y ) || is_object( $y ) ) ) {
			return TS_ASSERT_EQUALS_ARRAY( $x, $y, $msg );
	}
	if ( $x !== $y ) {

		$display = $_phpTestObject->output->getReportExpect( "===", $x, $y, $msg );
		return $_phpTestObject->assertionFailed( $display );
	}
	return( false );
}


function TS_ASSERT_DIFFERS( $x, $y, $msg="" )
{
	global $_phpTestObject;
	if ( (is_array( $x ) || is_object( $x )) || ( is_array( $y ) || is_object( $y ) ) ) {
			return TS_ASSERT_DIFFERS_ARRAY( $x, $y, $msg );
	}

	if ( $x === $y ) {
		$display = $_phpTestObject->output->getReportExpectNot( "!==", $x, $y, $msg );
		return $_phpTestObject->assertionFailed( $display );//"'$x' !== '$y'" . ( $msg != "" ) ? " : " . $msg : "" );
	}
	return( false );
}

/**
 * Assert that $x > $y
 * @global phpTest $_phpTestObject
 * @param mixed $x
 * @param mixed $y
 * @param string $msg
 * @return bool true on success.
 */
function TS_ASSERT_GREATER( $x, $y, $msg=null )
{
	global $_phpTestObject;
	if ( !( $x > $y  ) ) {

		$display = $_phpTestObject->output->getReportExpect( ">", $x, $y, $msg );
		return $_phpTestObject->assertionFailed( $display );
	}
	return( false );
}
function TS_ASSERT_GREATER_OR_EQUALS( $x, $y, $msg=null )
{
	global $_phpTestObject;
	if ( !( $x >= $y  ) ) {

		$display = $_phpTestObject->output->getReportExpect( ">=", $x, $y, $msg );
		return $_phpTestObject->assertionFailed( $display );
	}
	return( false );
}

function TS_ASSERT_LESS_THEN( $x, $y, $msg=null )
{
	global $_phpTestObject;
	if ( !( $x < $y  ) ) {

		$display = $_phpTestObject->output->getReportExpect( "<", $x, $y, $msg );
		return $_phpTestObject->assertionFailed( $display );
	}
	return( false );
}
function TS_ASSERT_LESSER_OR_EQUALS( $x, $y, $msg=null )
{
	global $_phpTestObject;
	if ( !( $x <= $y  ) ) {

		$display = $_phpTestObject->output->getReportExpect( "<=", $x, $y, $msg );
		return $_phpTestObject->assertionFailed( $display );
	}
	return( false );
}


/**
 * Assert that $x contains $y
 *
 * @param string $x
 * @param string  $y
 * @param string  $msg
 * @return bool  assert result
 */
function TS_ASSERT_CONTAINS( $x, $y, $msg="" )
{
	global $_phpTestObject;
	//print_r( func_get_arg() );
	if ( FALSE === strpos( $x, $y ) ) {
		$display = $_phpTestObject->output->getReportXY( "contains", $x, $y, $msg );
		return $_phpTestObject->assertionFailed( $display );
	}
	return( false );
}
function TS_FAIL( $msg="" )
{
	global $_phpTestObject;
	return( $_phpTestObject->assertionFailed( "" . (( $msg ) ? "\n\tMessage: " . $msg : "")) );
}
function TS_ASSERT_NOT_CONTAINS( $x, $y, $msg="" )
{
	global $_phpTestObject;
	//print_r( func_get_arg() );
	if ( FALSE !== strpos( $x, $y ) ) {
		$display = $_phpTestObject->output->getReportXY( "not contains", $x, $y, $msg );
		return $_phpTestObject->assertionFailed( $display );
	}
	return( false );
}

function TS_ISFAILED()
{
	global $_phpTestObject;
	return( $_phpTestObject->isTestFailed() );
}

function TS_TRACE( $msg )
{
	global $_phpTestObject;
	return( $_phpTestObject->trace( $msg ) );
}

/**
 * Assert equals array
 *
 * @param array $x
 * @param array $y
 * @param string $msg
 */
function TS_ASSERT_EQUALS_ARRAY( $x, $y, $msg="")
{
	ob_start();
	print_r( $x );
	$strx = ob_get_clean();
	
	ob_start();
	print_r( $y );
	$stry = ob_get_clean();

	
	if ( $strx != $stry && function_exists( 'xdiff_string_diff') ) {
		$diff = "diff: " .xdiff_string_diff( $strx, $stry );
	}
	else {
		$diff = "";
	}
	TS_ASSERT_EQUALS( $strx, $stry, $msg . $diff);
}
/**
 * Assert equals array
 *
 * @param array $x
 * @param array $y
 * @param string $msg
 */
function TS_ASSERT_DIFFERS_ARRAY( $x, $y, $msg="")
{
	ob_start();
	print_r( $x );
	$strx = ob_get_clean();

	ob_start();
	print_r( $y );
	$stry = ob_get_clean();


	if ( $strx != $stry && function_exists( 'xdiff_string_diff') ) {
		$diff = "diff: " .xdiff_string_diff( $strx, $stry );
	}
	else {
		$diff = "";
	}
	TS_ASSERT_DIFFERS( $strx, $stry, $msg . $diff);
}

?>