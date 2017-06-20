<?php
namespace inklabs\kommerce\Lib;

interface SessionInterface
{
    /**
     * @param string $key
     * @return mixed|null
     */
    public function get(string $key);

    /**
     * @param string $key
     * @param mixed $data
     */
    public function set(string $key, $data);

    public function delete(string $key);
}
