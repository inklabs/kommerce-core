<?php
namespace inklabs\kommerce\Lib;

class Slug
{
    public static function get($string)
    {
        $slug = preg_replace(
            ['/\'/', '/[^a-z0-9-]+/'],
            ['',     '-'],
            strtolower($string)
        );
        return preg_replace('/-+/', '-', $slug);
    }
}
