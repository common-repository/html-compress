<?php
include dirname(__FILE__) . '/../../html-compress/cssCompress.class.php';

class cssCompressTest extends PHPUnit_Framework_TestCase
{
	
	
	public function testDelComments()
	{
		$css_sta = '/* comment */';
		$css_end = '';
		$css_pro = cssCompress::delComments($css_sta);
		$this->assertEquals($css_pro,$css_end);
	}
	
	public function testDelSpace()
	{
		$css_sta = ' ; ';
		$css_end = ';';
		$css_pro = cssCompress::delSpace($css_sta);
		$this->assertEquals($css_pro,$css_end);
		
		$css_sta = ' ( ';
		$css_end = '(';
		$css_pro = cssCompress::delSpace($css_sta);
		$this->assertEquals($css_pro,$css_end);
	}
	
	public function testCompress()
	{
		$css_sta = <<<CSS
#eskuin .zabala { /* Erabili eskero #erdi ez erabili */
	width: 560px;
	background: red;
}
CSS;
		$css_end = '#eskuin .zabala{width:560px;background:red;}';
		$css_pro = cssCompress::Compress($css_sta);
		$this->assertEquals($css_pro,$css_end);
	}
}