<?php
include dirname(__FILE__) . '/../../html-compress/Compress.class.php';

class CompressTest extends PHPUnit_Framework_TestCase
{
	function testSplitCode()
	{
		// js bat
		$html = '<html><script>javascript</script>html</html>';
		$result = Compress::splitCode($html);
		$this->assertEquals($result,'<html><script>__JAVASCRIPTCOMPRESS[0]__</script>html</html>');
		$this->assertEquals(Compress::$jsCodes[0],'javascript');
		
		// css bat
		$html = '<html><style>css</style>html</html>';
		$result = Compress::splitCode($html);
		$this->assertEquals($result,'<html><style>__CSSCOMPRESS[0]__</style>html</html>');
		$this->assertEquals(Compress::$cssCodes[0],'css');
		
		// js eta css bat
		$html = '<html><script>javascript</script><style>css</style>html</html>';
		$result = Compress::splitCode($html);
		$this->assertEquals($result,'<html><script>__JAVASCRIPTCOMPRESS[0]__</script><style>__CSSCOMPRESS[0]__</style>html</html>');
		$this->assertEquals(Compress::$cssCodes[0],'css');
		$this->assertEquals(Compress::$jsCodes[0],'javascript');

		// 2 js
		$html = '<html><script>javascript</script><script>javascript_2</script>html</html>';
		$result = Compress::splitCode($html);
		$this->assertEquals($result,'<html><script>__JAVASCRIPTCOMPRESS[0]__</script><script>__JAVASCRIPTCOMPRESS[1]__</script>html</html>');
		$this->assertEquals(Compress::$jsCodes[0],'javascript');
		$this->assertEquals(Compress::$jsCodes[1],'javascript_2');
		
		// 2 css
		$html = '<html><style>css</style><style>css_2</style>html</html>';
		$result = Compress::splitCode($html);
		$this->assertEquals($result,'<html><style>__CSSCOMPRESS[0]__</style><style>__CSSCOMPRESS[1]__</style>html</html>');
		$this->assertEquals(Compress::$cssCodes[0],'css');
		$this->assertEquals(Compress::$cssCodes[1],'css_2');
		
		// js aukerekin
		$html = '<html><script type="text/javascript">javascript</script>html</html>';
		$result = Compress::splitCode($html);
		$this->assertEquals($result,'<html><script type="text/javascript">__JAVASCRIPTCOMPRESS[0]__</script>html</html>');
		$this->assertEquals(Compress::$jsCodes[0],'javascript');
		 
		// css aukerekin
		$html = '<html><style type="text/css">css</style>html</html>';
		$result = Compress::splitCode($html);
		$this->assertEquals($result,'<html><style type="text/css">__CSSCOMPRESS[0]__</style>html</html>');
		$this->assertEquals(Compress::$cssCodes[0],'css');
	}
	
	function testMergeCode()
	{
		// batu js bat
		compress::$jsCodes = array();
		compress::$jsCodes[] = 'Code A';
		$html_sta = '<html><script>__JAVASCRIPTCOMPRESS[0]__</script>html</html>';
		$html_end = '<html><script>Code A</script>html</html>';
		$result = Compress::mergeCode($html_sta);
		$this->assertEquals($result,$html_end);
		
		// batu 2 js bat
		compress::$jsCodes = array();
		compress::$jsCodes[] = 'Code A';
		compress::$jsCodes[] = 'Code B';
		$html_sta = '<html><script>__JAVASCRIPTCOMPRESS[0]__</script><script>__JAVASCRIPTCOMPRESS[1]__</script>html</html>';
		$html_end = '<html><script>Code A</script><script>Code B</script>html</html>';
		$result = Compress::mergeCode($html_sta);
		$this->assertEquals($result,$html_end);
		
		// batu css bat
		compress::$cssCodes = array();
		compress::$cssCodes[] = 'Code A';
		$html_sta = '<html><style>__CSSCOMPRESS[0]__</style>html</html>';
		$html_end = '<html><style>Code A</style>html</html>';
		$result = Compress::mergeCode($html_sta);
		$this->assertEquals($result,$html_end);
		
		// batu 2 css bat
		compress::$cssCodes = array();
		compress::$cssCodes[] = 'Code A';
		compress::$cssCodes[] = 'Code B';
		$html_sta = '<html><style>__CSSCOMPRESS[0]__</style><style>__CSSCOMPRESS[1]__</style>html</html>';
		$html_end = '<html><style>Code A</style><style>Code B</style>html</html>';
		$result = Compress::mergeCode($html_sta);
		$this->assertEquals($result,$html_end);
	}

	function testCompress()
	{
		$html_sta = ' <html><script> a = 2 ; b = 3; c = a + b ; </script></html> ';
		$html_end = '<html><script>a=2;b=3;c=a+b;</script></html>';
		$result = compress::Compress($html_sta);
		$this->assertEquals($result,$html_end);
		
		$html_sta = ' <html><style> body { border: 1px solid red; float: left } </style></html> ';
		$html_end = '<html><style>body{border:1px solid red;float:left}</style></html>';
		$result = compress::Compress($html_sta);
		$this->assertEquals($result,$html_end);
	}
}