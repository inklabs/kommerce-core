<?php
namespace inklabs\kommerce\Lib;

class ArraySessionManager implements SessionManager
{
    protected $session = [];

    /**
     * @param string $key
     * @return mixed|null
     */
    public function get($key)
    {
        if (isset($this->session[$key])) {
            return unserialize($this->session[$key]);
        } else {
            return null;
        }
    }

    /**
     * @param string $key
     * @param mixed $data
     */
    public function set($key, $data)
    {
        $this->session[$key] = serialize($data);
    }

    /**
     * @param string $key
     */
    public function delete($key)
    {
        unset($this->session[$key]);
    }
}
