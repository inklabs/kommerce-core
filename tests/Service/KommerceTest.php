<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Lib as Lib;
use inklabs\kommerce\tests\Helper as Helper;
use Doctrine as Doctrine;

class KommerceTest extends Helper\DoctrineTestCase
{
    public function testClearCache()
    {
        $kommerce = new Kommerce(new Doctrine\Common\Cache\ArrayCache());
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
        $this->assertTrue($this->kommerce->getEntityManager() instanceof Doctrine\ORM\EntityManager);
    }

    public function testSetupSqlLogger()
    {
        $this->kommerce->setSqlLogger(new Doctrine\DBAL\Logging\EchoSQLLogger);
    }

    public function testService()
    {
        $image = $this->kommerce->service('Image');
        $this->assertTrue($image instanceof Image);
    }

    public function testPricingService()
    {
        $this->kommerce->setupPricing();
        $product = $this->kommerce->pricingService('Product');
        $this->assertTrue($product instanceof Product);
    }

    public function testPricingSessionService()
    {
        $this->kommerce->setSessionManager(new Lib\ArraySessionManager);
        $this->kommerce->setupPricing();
        $cart = $this->kommerce->pricingSessionService('Cart');
        $this->assertTrue($cart instanceof Cart);
    }

    public function testSessionService()
    {
        $this->kommerce->setSessionManager(new Lib\ArraySessionManager);
        $user = $this->kommerce->sessionService('User');
        $this->assertTrue($user instanceof User);
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
