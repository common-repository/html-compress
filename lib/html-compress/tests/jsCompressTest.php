<?php
include dirname(__FILE__) . '/../../html-compress/jsCompress.class.php';

class jsCompressTest extends PHPUnit_Framework_TestCase
{
	public function testOutStrings()
	{
		// ketak ez dira aldatu behar
		$js_sta = ' a = "  string  "';
		$js_end = ' a = __STRINGCOMPRESS[0]__';
		$js_pro = jsCompress::outStrings($js_sta);
		$this->assertEquals($js_pro,$js_end);
		
		$arrExpected = array('"  string  "');
		$this->assertEquals(jsCompress::$jsStrings,$arrExpected);
		
		$js_sta = ' a = "  string  " b = "  string2  "';
		$js_end = ' a = __STRINGCOMPRESS[0]__ b = __STRINGCOMPRESS[1]__';
		$js_pro = jsCompress::outStrings($js_sta);
		$this->assertEquals($js_pro,$js_end);
		
		$arrExpected = array('"  string  "','"  string2  "');
		$this->assertEquals(jsCompress::$jsStrings,$arrExpected);
		
		$js_sta = ' a = \'  string  \'';
		$js_end = ' a = __STRINGCOMPRESS[0]__';
		$js_pro = jsCompress::outStrings($js_sta);
		$this->assertEquals($js_pro,$js_end);
		
		$arrExpected = array('\'  string  \'');
		$this->assertEquals(jsCompress::$jsStrings,$arrExpected);
		
		$js_sta = ' a = \'  string  \' b = \'  string2  \'';
		$js_end = ' a = __STRINGCOMPRESS[0]__ b = __STRINGCOMPRESS[1]__';
		$js_pro = jsCompress::outStrings($js_sta);
		$this->assertEquals($js_pro,$js_end);
		
		$arrExpected = array('\'  string  \'','\'  string2  \'');
		$this->assertEquals(jsCompress::$jsStrings,$arrExpected);

		$js_sta = ' a = "  string  " b = \'  string2  \'';
		$js_end = ' a = __STRINGCOMPRESS[0]__ b = __STRINGCOMPRESS[1]__';
		$js_pro = jsCompress::outStrings($js_sta);
		$this->assertEquals($js_pro,$js_end);
		
		$arrExpected = array('"  string  "','\'  string2  \'');
		$this->assertEquals(jsCompress::$jsStrings,$arrExpected);
		
		# issue 1
		$js_sta = ' a = ""';
		$js_end = ' a = __STRINGCOMPRESS[0]__';
		$js_pro = jsCompress::outStrings($js_sta);
		$this->assertEquals($js_pro,$js_end);
		
		# issue 1
		$js_sta = ' a = \'\'';
		$js_end = ' a = __STRINGCOMPRESS[0]__';
		$js_pro = jsCompress::outStrings($js_sta);
		$this->assertEquals($js_pro,$js_end);
	}
	
	public function testInStrings()
	{
		// testuak berrezarri
		$js_sta = ' a = "  string  " b = \'  string2  \'';
		$js = jsCompress::outStrings($js_sta);
		$js_end = jsCompress::inStrings($js);
		$this->assertEquals($js_sta,$js_end);
	}
	
	public function testDelSpace()
	{
		// utsune bat baino gehiago
		$js_sta = '  ';
		$js_end = '';
		$js_pro = jsCompress::delSpace($js_sta);
		$this->assertEquals($js_pro,$js_end);
		
		// = en atze eta aurrean ez da behar utsunerik
		$js_sta = 'a =b';
		$js_end = 'a=b';
		$js_pro = jsCompress::delSpace($js_sta);
		$this->assertEquals($js_pro,$js_end);
		
		$js_sta = 'a= b';
		$js_end = 'a=b';
		$js_pro = jsCompress::delSpace($js_sta);
		$this->assertEquals($js_pro,$js_end);
		
		$js_sta = 'a = b + c';
		$js_end = 'a=b+c';
		$js_pro = jsCompress::delSpace($js_sta);
		$this->assertEquals($js_pro,$js_end);
		
		$js_sta = 'a = b; c = d;';
		$js_end = 'a=b;c=d;';
		$js_pro = jsCompress::delSpace($js_sta);
		$this->assertEquals($js_pro,$js_end);
		
		$js_sta = 'a = b ;c = d;';
		$js_end = 'a=b;c=d;';
		$js_pro = jsCompress::delSpace($js_sta);
		$this->assertEquals($js_pro,$js_end);
		
		$js_sta = 'array( a, b, c, d);';
		$js_end = 'array(a,b,c,d);';
		$js_pro = jsCompress::delSpace($js_sta);
		$this->assertEquals($js_pro,$js_end);
		
		$js_sta = 'if (elem) { action }';
		$js_end = 'if(elem){action}';
		$js_pro = jsCompress::delSpace($js_sta);
		$this->assertEquals($js_pro,$js_end);
	}
	
	public function testDelComments()
	{
		$js_sta = '/* comment */';
		$js_end = '';
		$js_pro = jsCompress::delComments($js_sta);
		$this->assertEquals($js_pro,$js_end);
		
		$js_sta = ' string /* comment */';
		$js_end = ' string ';
		$js_pro = jsCompress::delComments($js_sta);
		$this->assertEquals($js_pro,$js_end);
		
		$js_sta = '/* comment */ string ';
		$js_end = ' string ';
		$js_pro = jsCompress::delComments($js_sta);
		$this->assertEquals($js_pro,$js_end);
		
		$js_sta = <<<JS
/*
comment
*/
JS;
		$js_end = <<<JS
JS;
		$js_pro = jsCompress::delComments($js_sta);
		$this->assertEquals($js_pro,$js_end);
		
		$js_sta = '// comment';
		$js_end = '';
		$js_pro = jsCompress::delComments($js_sta);
		$this->assertEquals($js_pro,$js_end);
		
		$js_sta = ' string // comment';
		$js_end = ' string ';
		$js_pro = jsCompress::delComments($js_sta);
		$this->assertEquals($js_pro,$js_end);
		
		$js_sta = <<<JS
string
// comment
JS;
		$js_end = <<<JS
string

JS;
		$js_pro = jsCompress::delComments($js_sta);
		$this->assertEquals($js_pro,$js_end);
		
		$js_sta = <<<JS
// comment
string
JS;
		$js_end = <<<JS

string
JS;
		$js_pro = jsCompress::delComments($js_sta);
		$this->assertEquals($js_pro,$js_end);
		
		$js_sta = <<<JS
// comment
string
// comment
string
// comment
JS;
		$js_end = <<<JS

string

string

JS;
		$js_pro = jsCompress::delComments($js_sta);
		$this->assertEquals($js_pro,$js_end);
		
		$js_sta = <<<JS
/* c1 */
string
/* c2 */
string

JS;
		$js_end = <<<JS

string

string

JS;

		$js_pro = jsCompress::delComments($js_sta);
		$this->assertEquals($js_pro,$js_end);
	}
	
	public function testCompress()
	{
		$js_sta = <<<JS
var a = " my firts string"
var b = 'other string      ';
res = a + b
JS;
		$js_end = 'var a=" my firts string" var b=\'other string      \';res=a+b';
		$js_pro = jsCompress::compress($js_sta);
		$this->assertEquals($js_pro,$js_end);
		
		// Issue 1: https://code.google.com/p/html-compress/issues/detail?id=1
		$js_sta = <<<JS
	var analyticsFileTypes = [''];
	var analyticsEventTracking = 'enabled';
JS;
		$js_end = 'var analyticsFileTypes=[\'\'];var analyticsEventTracking=\'enabled\';';
		$js_pro = jsCompress::compress($js_sta);
		$this->assertEquals($js_pro,$js_end);
		
		// Issue 2: https://code.google.com/p/html-compress/issues/detail?id=2
		$js_sta = <<<JS
/* <![CDATA[ */
var emailL10n = {
	ajax_url: "http://zuzeu/wp-content/plugins/wp-email/wp-email.php",
	max_allowed: "5"
};
/* ]]> */
JS;
		$js_end = 'var emailL10n={ajax_url:"http://zuzeu/wp-content/plugins/wp-email/wp-email.php",max_allowed:"5"};';
		$js_pro = jsCompress::compress($js_sta);
		$this->assertEquals($js_pro,$js_end);
		
	}
	
}
