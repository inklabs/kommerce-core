<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity as Entity;

class StubEntityManager extends EntityManager
{
    public function find($id)
    {
        return $id;
    }
}
