<?php
namespace inklabs\kommerce\Lib;

class Slug
{
    public static function get($string)
    {
        $slug = preg_replace(
            array('/\'/', '/[^a-z0-9-]+/'),
            array('',     '-'),
            strtolower($string)
        );
        return preg_replace('/-+/', '-', $slug);
    }
}
