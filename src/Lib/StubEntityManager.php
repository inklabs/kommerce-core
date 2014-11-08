<?php
namespace inklabs\kommerce\Lib;

class StubEntityManager extends EntityManager
{
    public function find($id)
    {
        return $id;
    }
}
