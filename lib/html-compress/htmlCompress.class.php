<?php
include_once 'baseCompress.class.php';
/**
 * @Pacage karrikaslib
 * @Subpacage compress
 */
/**
 * Htmlan ahal den modu guztietan murriztu zentzua galdu gabe.
 */
class htmlCompress extends baseCompress
{
	static public function compress( $html )
	{
		$html = self::delComment( $html );
		$html = self::delTab( $html );
		$html = self::delNL( $html );
		$html = self::delSpace( $html );

		return $html;
	}

	static public function delComment( $html )
	{
		// iruzkinak kendu.
		$html = preg_replace('/<!(?<comment>--).*?-->/si', '', $html);

		return $html;
	}
}