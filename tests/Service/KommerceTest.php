<?php
namespace inklabs\kommerce\Service;

class KommerceTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->kommerce = new Kommerce([
            'driver'   => 'pdo_sqlite',
            'memory'   => true,
        ]);
    }

    public function testGetEntityManager()
    {
        $this->assertInstanceOf('Doctrine\ORM\EntityManager', $this->kommerce->getEntityManager());
    }

    public function testSetupSqlLogger()
    {
        $this->kommerce->setSqlLogger(new \Doctrine\DBAL\Logging\EchoSQLLogger);
    }

    public function testService()
    {
        $product = $this->kommerce->service('Product');
        $this->assertInstanceOf('inklabs\kommerce\Service\Product', $product);
    }
}
