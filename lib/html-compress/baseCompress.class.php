<?php
/**
 * @Pacage karrikaslib
 * @Subpacage compress
 */
class baseCompress
{
	static public function delSpace( $html )
	{
		// hasiera eta amaiera garbitu.
		$html = trim($html);
		// utsune bikoitzak kendu.
		$html = preg_replace('/[ ]+/', ' ', $html);
		// Etiketen aurreko eta ondorengo utsuneak kendu.
		$html = preg_replace('/>[ ]+/', '> ', $html);
		$html = preg_replace('/[ ]+</', ' <', $html);

		return $html;
	}

	static public function delTab( $html )
	{
		// tabulazioak kendu.
		$html = preg_replace('/[\t]+/', ' ', $html);

		return $html;
	}

	static public function delNL( $html )
	{
		// saltoak kendu.
		$html = preg_replace('/[\n\r]+/', ' ', $html);

		return $html;
	}
}