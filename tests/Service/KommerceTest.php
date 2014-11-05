<?php
namespace inklabs\kommerce\Service;

class KommerceTest extends \inklabs\kommerce\tests\Helper\DoctrineTestCase
{
    public function testWithArrayCacheDriver()
    {
        $kommerce = new Kommerce(new \Doctrine\Common\Cache\ArrayCache());
    }

    public function testClearCache()
    {
        $kommerce = new Kommerce(new \Doctrine\Common\Cache\ArrayCache());
        $kommerce->setup([
            'driver'   => 'pdo_sqlite',
            'memory'   => true,
        ]);

        $cacheDriver = $kommerce->getCacheDriver();
        $id = 'test-id';
        $data = 'test-data';
        $cacheDriver->save($id, $data);

        $this->assertSame($data, $cacheDriver->fetch($id));

        $kommerce->clearCache();

        $this->assertSame(false, $cacheDriver->fetch($id));
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

    public function testSessionService()
    {
        $this->kommerce->setSessionManager(new ArraySessionManager);
        $cart = $this->kommerce->sessionService('Cart');
        $this->assertInstanceOf('inklabs\kommerce\Service\Cart', $cart);
    }

    public function testAddSqliteFunctions()
    {
        $this->kommerce->addSqliteFunctions();
    }

    public function testAddMysqlFunctions()
    {
        $this->kommerce->addMysqlFunctions();
    }
}
