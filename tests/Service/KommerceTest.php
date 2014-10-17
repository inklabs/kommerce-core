<?php
namespace inklabs\kommerce\Service;

class KommerceTest extends DoctrineTestCase
{
    public function setUp()
    {
    }

    public function testGetEntityManager()
    {
        $this->assertInstanceOf('Doctrine\ORM\EntityManager', $this->entityManager);
    }

    // public function testSetupSqlLogger()
    // {
    //     $this->kommerce->setSqlLogger(new \Doctrine\DBAL\Logging\EchoSQLLogger);
    // }
}
