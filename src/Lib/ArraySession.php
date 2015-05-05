<?php
namespace inklabs\kommerce\Lib;

class ArraySession implements SessionInterface
{
    protected $session = [];

    public function get($key)
    {
        if (isset($this->session[$key])) {
            return unserialize($this->session[$key]);
        } else {
            return null;
        }
    }

    public function set($key, $data)
    {
        $this->session[$key] = serialize($data);
    }

    public function delete($key)
    {
        unset($this->session[$key]);
    }
}
