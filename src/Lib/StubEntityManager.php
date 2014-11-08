<?php
namespace inklabs\kommerce\Lib;

class StubEntityManager extends \inklabs\kommerce\Lib\EntityManager
{
    public function find($id)
    {
        return $id;
    }
}
