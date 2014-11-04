<?php
namespace inklabs\kommerce\Service;

abstract class SessionManager
{
    abstract public function get($key);
    abstract public function set($key, $data);
}
