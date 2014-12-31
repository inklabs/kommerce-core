<?php
namespace inklabs\kommerce\Doctrine\ORM;

use inklabs\kommerce\Lib\BaseConvert;

class EntityRepository extends \Doctrine\ORM\EntityRepository
{
    public function getQueryBuilder()
    {
        return new QueryBuilder($this->getEntityManager());
    }
}
