<?php
namespace inklabs\kommerce\tests\Helper;

use inklabs\kommerce\Lib as Lib;

class StubEntityManager extends Lib\EntityManager
{
    public function find($id)
    {
        return $id;
    }
}
