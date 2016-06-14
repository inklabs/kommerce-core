<?php
namespace inklabs\kommerce\Lib\Query;

interface QueryInterface
{
    /**
     * @return mixed
     */
    public function getRequest();

    /**
     * @return mixed
     */
    public function getResponse();
}
