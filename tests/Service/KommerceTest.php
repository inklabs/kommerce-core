<?php
namespace inklabs\kommerce\Service;

class KommerceTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->kommerce = Kommerce::factory();
        $this->kommerce->setup([
            'driver'   => 'pdo_sqlite',
            'memory'   => true,
        ]);
    }

    public function testGetEntityManager()
    {
        $entityManager = $this->kommerce->getEntityManager();
        $this->assertInstanceOf('Doctrine\ORM\EntityManager', $entityManager);
    }

    public function testSetupSqlLogger()
    {
        $this->kommerce->setSqlLogger(new \Doctrine\DBAL\Logging\EchoSQLLogger);
    }
}
