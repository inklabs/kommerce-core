<?php
namespace inklabs\kommerce\Lib;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\tests\Helper as Helper;

class EntityManagerTest extends Helper\DoctrineTestCase
{
    public function testCreate()
    {
        $emClass = new EntityManager;
        $emClass->setEntityManager($this->entityManager);
    }
}
