<?php
include_once 'baseCompressTest.php';
include_once 'htmlCompressTest.php';
include_once 'cssCompressTest.php';
include_once 'jsCompressTest.php';
include_once 'CompressTest.php';

class testSuite
{
    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite();
 
		$suite->addTestSuite('baseCompressTest');
		$suite->addTestSuite('htmlCompressTest');
		$suite->addTestSuite('cssCompressTest');
		$suite->addTestSuite('jsCompressTest');
		$suite->addTestSuite('CompressTest');
 
        return $suite;
    }
}
