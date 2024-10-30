<?php
include dirname(__FILE__) . '/../../html-compress/htmlCompress.class.php';

class htmlCompressTest extends PHPUnit_Framework_TestCase
{
	/**
	 * Html iruzkinak ezabatu.
	 */
	public function testDelComment()
	{
		$html = '<!-- testu bat edo -->';
		$esperotakoa = '';
		$emaitza = htmlCompress::delComment($html);
		$this->assertEquals($emaitza,$esperotakoa);

		$html = '<!-- a --> b <!-- c --> d <!-- e -->';
		$esperotakoa = ' b  d ';
		$emaitza = htmlCompress::delComment($html);
		$this->assertEquals($emaitza,$esperotakoa);

		$html = <<<HTML
<!-- 
a 
-->
HTML;
		$esperotakoa = '';
		$emaitza = htmlCompress::delComment($html);
		$this->assertEquals($emaitza,$esperotakoa);
	}

	/**
	 * Html ahalik eta txikituen utzi.
	 */
	public function testCompress()
	{
		$html = '<html></html>';
		$emaitza = htmlCompress::compress($html);
		$this->assertEquals($emaitza,$html);

		$html = <<<HTML
<h1>This is a heading</h1>

<h2>This is a heading</h2>

<h3>This is a heading</h3>
HTML;
		$esperotakoa = '<h1>This is a heading</h1> <h2>This is a heading</h2> <h3>This is a heading</h3>';
		$emaitza = htmlCompress::compress($html);
		$this->assertEquals($emaitza,$esperotakoa);
		
		$html = '<span>|</span> <span><a href="#">text</a></span> <span>|</span>';
		$esperotakoa = '<span>|</span> <span><a href="#">text</a></span> <span>|</span>';
		$emaitza = htmlCompress::compress($html);
		$this->assertEquals($emaitza,$esperotakoa);
	}
}