<?php
include_once 'htmlCompress.class.php';
include_once 'jsCompress.class.php';
include_once 'cssCompress.class.php';
/**
 * Web orri bat ahalik eta gehien murrizten du 
 * funtzionamendua mantenduz.
 * 
 * @author karrikas
 */
class compress
{
	/**
	 * JS kodeak gordetzeko array statikoa.
	 * @var array
	 */
	static $jsCodes = array();
	
	/**
	 * Css kodeak gordetzeko arrya.
	 * @var array (html: html code, js: js code, css: css code)
	 */
	static $cssCodes = array();
	
	/**
	 * Honek Compress metodoa konstrukturea izatea ekiditen du.
	 */
	public function __construct(){}
	
	
	static public function Compress( $html )
	{
		self::emptyVars();
		
		// html zatitu
		$html = self::splitCode( $html );
		
		// html txikitu
		$html = htmlCompress::Compress($html);
		
		// js txikitu
		foreach(self::$jsCodes as $key => $jsCode)
		{
			self::$jsCodes[$key] = jsCompress::Compress( $jsCode );
		}
		
		// css txikitu
		foreach(self::$cssCodes as $key => $cssCode)
		{
			self::$cssCodes[$key] = cssCompress::Compress( $cssCode );
		}
		
		// kodea batu
		$html = self::mergeCode( $html );
		
		return $html;
	}
	
	/**
	 * Batu js eta css guztiak htmlarekin.
	 * @param string $html
	 * @return string $html
	 */
	static public function mergeCode( $html )
	{
		// merge js
		foreach(self::$jsCodes as $key => $jsCode)
		{
			$html = str_replace("__JAVASCRIPTCOMPRESS[$key]__", $jsCode, $html);
		}
		
		// merge js
		foreach(self::$cssCodes as $key => $cssCode)
		{
			$html = str_replace("__CSSCOMPRESS[$key]__", $cssCode, $html);
		}
		
		return $html;
	}
	
	/**
	 * html, css, js banatzen ditu gero procesatzeko.
	 * 
	 * @param string $html
	 * @return array 
	 */
	static public function splitCode( $html )
	{
		// aurrekoak ustu
		self::emptyVars();
		
		// javascript kodeak atera.
		$html = preg_replace_callback('/(<script[^>]*>)(.*?)(\<\/script>)/si','self::addJsCode', $html);
		
		// Css kodeak atera.
		$html = preg_replace_callback('/(<style[^>]*>)(.*?)(<\/style>)/si','self::addCssCode', $html);
		
		// return split result
		return $html;
	}
	
	static private function addJsCode( $js )
	{
		$count = count(self::$jsCodes);
		self::$jsCodes[] = $js[2];
		
		return "{$js[1]}__JAVASCRIPTCOMPRESS[$count]__{$js[3]}";
	} 
	
	static private function addCssCode( $css )
	{
		$count = count(self::$cssCodes);
		self::$cssCodes[] = $css[2];
		
		return "{$css[1]}__CSSCOMPRESS[$count]__{$css[3]}";
	} 
	
	/**
	 * Hasierako bariableak ustu.
	 */
	static private function emptyVars()
	{
		self::$cssCodes = array();
		self::$jsCodes = array();
	} 
}