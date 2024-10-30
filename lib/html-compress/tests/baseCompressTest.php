<?php
include dirname(__FILE__) . '/../../html-compress/baseCompress.class.php';

class baseCompressTest extends PHPUnit_Framework_TestCase
{
	/**
	 * Utsuneak ezabatu.
	 */
	public function testDelSpace()
	{
		$html = '       ';
		$esperotakoa = '';
		$emaitza = baseCompress::delSpace($html);
		$this->assertEquals($emaitza,$esperotakoa);
		
		$html = ' a b c d e ';
		$esperotakoa = 'a b c d e';
		$emaitza = baseCompress::delSpace($html);
		$this->assertEquals($emaitza,$esperotakoa);
		
		$html = '  a  b  c  d  e  ';
		$esperotakoa = 'a b c d e';
		$emaitza = baseCompress::delSpace($html);
		$this->assertEquals($emaitza,$esperotakoa);
	}

	/**
	 * Tabulazioak ezabatu.
	 */
	public function testDelTab()
	{
		$html = '					';
		$esperotakoa = ' ';
		$emaitza = baseCompress::delTab($html);
		$this->assertEquals($emaitza,$esperotakoa);
		
		$html = '	<div>	testu	bat		</div>	';
		$esperotakoa = ' <div> testu bat </div> ';
		$emaitza = baseCompress::delTab($html);
		$this->assertEquals($emaitza,$esperotakoa);
		
		$html = '		<div>		testu		bat			</div>		';
		$esperotakoa = ' <div> testu bat </div> ';
		$emaitza = baseCompress::delTab($html);
		$this->assertEquals($emaitza,$esperotakoa);
	}

	/**
	 * Saltoak ezabatu.
	 */
	public function testDelNL()
	{
		$html = <<<HTML



HTML;
		$esperotakoa = ' ';
		$emaitza = baseCompress::delNL($html);
		$this->assertEquals($emaitza,$esperotakoa);
		
		$html = <<<HTML
a
b
c
d
e
HTML;
		$esperotakoa = 'a b c d e';
		$emaitza = baseCompress::delNL($html);
		$this->assertEquals($emaitza,$esperotakoa);
	}
}