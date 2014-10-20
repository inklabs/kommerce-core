<?php
namespace inklabs\kommerce\Service;

class Base
{
    private static $encodeBase = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

	public static function decode($num, $base = NULL) {
		if ($base === NULL) {
			$base = static::$encodeBase;
		}

		$b = strlen($base);
		$limit = strlen($num);
		$res = strpos($base, $num[0]);

		for($i=1; $i < $limit; $i++) {
			$res = $b * $res + strpos($base, $num[$i]);
		}

		return (int) $res;
	}

	public static function encode($orig_num, $base = NULL) {
		if ($base === NULL) {
			$base = static::$encodeBase;
		}

		$b = strlen($base);
		$res = '';
		$num = $orig_num;
		
		do {
			$r = $num % $b;
			$num = floor($num / $b);
			$res = $base[$r] . $res;
		} while ($num);

		return $res;
	}
}
