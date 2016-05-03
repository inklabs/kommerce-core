<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\CartPriceRule;
use inklabs\kommerce\Entity\CatalogPromotion;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Lib\DoctrineHelper;
use inklabs\kommerce\tests\Helper;
use Doctrine;

class KommerceTest extends Helper\TestCase\ServiceTestCase
{
    protected $metaDataClassNames = [
        User::class,
        Cart::class,
        CatalogPromotion::class,
        CartPriceRule::class,
        Tag::class,
    ];

    public function testClearCache()
    {
        $kommerce = new DoctrineHelper(new Doctrine\Common\Cache\ArrayCache());
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
        $this->assertTrue($this->doctrineHelper->getEntityManager() instanceof Doctrine\ORM\EntityManager);
    }

    public function testSetupSqlLogger()
    {
        $this->doctrineHelper->setSqlLogger(new Doctrine\DBAL\Logging\EchoSQLLogger);
    }

    public function testAddSqliteFunctions()
    {
        if (! isset($_ENV['DB_NAME'])) {
            $this->doctrineHelper->addSqliteFunctions();
        }
    }

    public function testAddMysqlFunctions()
    {
        $this->doctrineHelper->addMysqlFunctions();
    }
}
