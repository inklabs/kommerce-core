<?php
namespace inklabs\kommerce\Lib;

abstract class SessionManager
{
    abstract public function get($key);
    abstract public function set($key, $data);
}
