<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Lib\DoctrineHelper;
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
        $this->doctrineHelper->addSqliteFunctions();
    }

    public function testAddMysqlFunctions()
    {
        $this->doctrineHelper->addMysqlFunctions();
    }
}
