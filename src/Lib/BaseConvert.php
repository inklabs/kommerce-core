<?php
namespace inklabs\kommerce\Lib;

class BaseConvert
{
    private static $encodeBase = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    /**
     * @param string $num
     * @param null $base
     * @return int|null
     */
    public static function decode($num, $base = null)
    {
        if ($num === null) {
            return null;
        }

        $num = (string) $num;

        if ($base === null) {
            $base = static::$encodeBase;
        }

        $b = strlen($base);
        $limit = strlen($num);
        $res = strpos($base, $num[0]);

        for ($i=1; $i < $limit; $i++) {
            $res = $b * $res + strpos($base, $num[$i]);
        }

        return (int) $res;
    }

    /**
     * @param string[] $encodedList
     * @param null $base
     * @return int[]
     */
    public static function decodeAll(array $encodedList, $base = null)
    {
        $decodedList = [];
        foreach ($encodedList as $encoded) {
            $decodedList[] = static::decode($encoded, $base);
        }
        return $decodedList;
    }

    /**
     * @param int $origNum
     * @param null $base
     * @return null|string
     */
    public static function encode($origNum, $base = null)
    {
        if ($origNum === null) {
            return null;
        }

        $origNum = (int) $origNum;

        if ($base === null) {
            $base = static::$encodeBase;
        }

        $b = strlen($base);
        $res = '';

        do {
            $r = $origNum % $b;
            $origNum = floor($origNum / $b);
            $res = $base[$r] . $res;
        } while ($origNum);

        return $res;
    }
}
