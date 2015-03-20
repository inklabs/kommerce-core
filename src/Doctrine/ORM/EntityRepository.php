<?php
namespace inklabs\kommerce\Doctrine\ORM;

class EntityRepository extends \Doctrine\ORM\EntityRepository
{
    public function getQueryBuilder()
    {
        return new QueryBuilder($this->getEntityManager());
    }
}
