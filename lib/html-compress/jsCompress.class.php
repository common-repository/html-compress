<?php
include_once 'baseCompress.class.php';
/**
 * Javascript codea ahalik eta murriztuen egitea funtzionatzeari utzi gabe.
 * 
 * @Pacage html-compress
 * @author karrikas
 */
class jsCompress extends baseCompress
{
	static $jsStrings = array();
	
	static public function compress( $js )
	{
		$js = self::outStrings($js);
		$js = self::delComments($js);
		$js = self::delSpace($js);
		$js = parent::delTab( $js );
		$js = parent::delNL( $js );
		$js = self::inStrings($js);
		
		return $js;
	}
	
	/**
	 * Kateak array batean gorde.
	 */
	static public function outStrings( $js )
	{
		// ustu aurreko baloreak
		self::$jsStrings = array();
		
		// kateak gorde
		$js = preg_replace_callback('/"[^"]*"|\'[^\']*\'/','self::addString', $js);
		
		return $js;
	}
	
	static private function addString( $string )
	{
		$count = count(self::$jsStrings);
		self::$jsStrings[] = $string[0];
		
		return "__STRINGCOMPRESS[$count]__";
	}
	
	/**
	 * Lehenago kendutako kateak berrezari
	 */
	static public function inStrings( $js )
	{
		foreach(self::$jsStrings as $key => $string)
		{
			$js = str_replace("__STRINGCOMPRESS[$key]__", $string, $js);
		}
		
		return $js;
	}
	
	static public function delSpace( $js )
	{		
		// oinarria aprobetsatu
		$js = parent::delSpace( $js );
		
		// spaces on = ; : , ( ) { } + 
		$js = preg_replace('/[ \t\n\r]*(=|;|:|,|\(|\)|\{|\}|\+)[ \t\n\r]*/',"$1",$js);
		
		return $js;
	}
	
	static public function delComments( $js )
	{
		// /*  */
		$js = preg_replace('/\/\*.*?\*\//ms','',$js);
		
		// //
		$js = preg_replace('/\/\/.*/','',$js);
		
		return $js;
	}
}