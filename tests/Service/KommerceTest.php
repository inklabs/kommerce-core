<?php
namespace inklabs\kommerce;

class ServiceKommerceTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->kommerce = Service\Kommerce::factory();
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
