<?php
/**
 * Class Helpers
 */

class Helpers
{
	/**
	 * @param string $helper
	 *
	 * @return \Nette\Callback
	 */
	public static function loader($helper)
	{
		if (is_callable($callback = __CLASS__ . '::' . $helper)) {
			return $callback;
		}
	}


	/**
	 * @param $value
	 *
	 * @return string
	 */
	public static function currency($value)
	{
		return str_replace(' ', "\xc2\xa0", number_format($value, 2, ',', ' ')) . "\xc2\xa0Kč";
	}
}
