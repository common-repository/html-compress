<?php
include_once 'baseCompress.class.php';
/**
 * @Pacage karrikaslib
 * @Subpacage compress
 */
/**
 * Htmlan ahal den modu guztietan murriztu zentzua galdu gabe.
 */
class cssCompress extends baseCompress
{
	static public function compress( $css )
	{
		$css = self::delComments( $css );
		$css = parent::delTab( $css );
		$css = parent::delNL( $css );
		$css = self::delSpace( $css );

		return $css;
	}

	static public function delSpace( $css )
	{
		$css = parent::delSpace( $css );

		// ;
		$css = preg_replace('/[ \t\n\r]*;[ \t\n\r]*/',';',$css);

		// :
		$css = preg_replace('/[ \t\n\r]*:[ \t\n\r]*/',':',$css);

		// ,
		$css = preg_replace('/[ \t\n\r]*,[ \t\n\r]*/',',',$css);

		// (
		$css = preg_replace('/[ \t\n\r]*\([ \t\n\r]*/','(',$css);

		// )
		$css = preg_replace('/[ \t\n\r]*\)[ \t\n\r]*/',')',$css);

		// {
		$css = preg_replace('/[ \t\n\r]*\{[ \t\n\r]*/','{',$css);

		// }
		$css = preg_replace('/[ \t\n\r]*\}[ \t\n\r]*/','}',$css);

		return $css;
	}

	static public function delComments( $css )
	{
		// /*  */
		$css = preg_replace('/\/\*.*\*\//ms','',$css);

		return $css;
	}
}