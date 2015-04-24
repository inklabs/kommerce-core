<?php
namespace inklabs\kommerce\Lib;

interface SessionManager
{
    /**
     * @param string $key
     * @return mixed|null
     */
    public function get($key);

    /**
     * @param string $key
     * @param mixed $data
     */
    public function set($key, $data);

    /**
     * @param string $key
     */
    public function delete($key);
}
