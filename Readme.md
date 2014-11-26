PhpTest  small unit-testing framework like CxxTest for C++.

Quick Start
===================

1. Write a test suite (testMyFeature.php):

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
<?php
class testMyFeature  extends PhpTest_TestSuite
{
   function testCase1() {
      $this->assertEquals( 2, 1+1 );
   }
   function testCase2() {
      $this->assertEquals( 3, 1+1 );
   }
}
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

2.  Run test suite
  
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
php  <phptestdir>/runner.php testMyfeature.php
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

or 

3. Run all test suites in curerent directory
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
php <phptestdir>/runner.php
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

