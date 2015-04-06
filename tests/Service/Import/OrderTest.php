<?php
namespace inklabs\kommerce\Service\Import;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Entity\View as View;
use inklabs\kommerce\Lib as Lib;
use inklabs\kommerce\tests\Helper as Helper;

class OrderTest extends Helper\DoctrineTestCase
{
    /** @var \Mockery\MockInterface|\inklabs\kommerce\EntityRepository\Order */
    protected $mockOrderRepository;

    /** @var \Mockery\MockInterface|\Doctrine\ORM\EntityManager */
    protected $mockEntityManager;

    /** @var Order */
    protected $orderService;

    public function setUp()
    {
        $this->mockOrderRepository = \Mockery::mock('inklabs\kommerce\EntityRepository\Order');

        $this->mockEntityManager = \Mockery::mock('Doctrine\ORM\EntityManager');
        $this->mockEntityManager
            ->shouldReceive('getRepository')
            ->once()
            ->andReturn($this->mockOrderRepository);

        $this->orderService = new Order($this->mockEntityManager);
    }

    public function testImport()
    {
        $numberRows = 3;

        $this->mockEntityManager
            ->shouldReceive('persist')
            ->times($numberRows)
            ->andReturnUndefined();

        $this->mockEntityManager
            ->shouldReceive('flush')
            ->once()
            ->andReturnUndefined();

        $iterator = new Lib\CSVIterator(__DIR__ . '/OrderTest.csv');
        $importedCount = $this->orderService->import($iterator);

        $this->assertSame($numberRows, $importedCount);
    }
}
