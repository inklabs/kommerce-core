<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Lib;
use inklabs\kommerce\tests\Helper;
use Doctrine;

class KommerceTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:User',
        'kommerce:Cart',
        'kommerce:CatalogPromotion',
        'kommerce:CartPriceRule',
        'kommerce:Tag',
    ];

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

    public function testAddSqliteFunctions()
    {
        $this->kommerce->addSqliteFunctions();
    }

    public function testAddMysqlFunctions()
    {
        $this->kommerce->addMysqlFunctions();
    }
}
