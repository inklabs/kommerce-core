<?php
namespace inklabs\kommerce\tests\Helper;

use inklabs\kommerce\Doctrine\ORM\EntityRepository;
use inklabs\kommerce\Lib as Lib;

class StubEntityRepository extends EntityRepository
{
    public function find($id)
    {
        return $id;
    }
}
