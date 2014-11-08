<?php
namespace inklabs\kommerce\Lib;

class ArraySessionManager extends SessionManager
{
    protected $session = [];

    public function get($key)
    {
        if (isset($this->session[$key])) {
            return $this->session[$key];
        } else {
            return null;
        }
    }

    public function set($key, $data)
    {
        $this->session[$key] = $data;
    }
}
