<?php
namespace inklabs\kommerce\tests\Helper;

class StubEntityManager extends \inklabs\kommerce\Lib\EntityManager
{
    public function find($id)
    {
        return $id;
    }
}
