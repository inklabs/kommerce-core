<?php
namespace inklabs\kommerce\Service\Import;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Entity\View as View;
use inklabs\kommerce\Lib as Lib;
use inklabs\kommerce\tests\Helper as Helper;

class OrderItemTest extends Helper\DoctrineTestCase
{
    /** @var \Mockery\MockInterface|\inklabs\kommerce\EntityRepository\OrderItem */
    protected $mockOrderItemRepository;

    /** @var \Mockery\MockInterface|\Doctrine\ORM\EntityManager */
    protected $mockEntityManager;

    /** @var OrderItem */
    protected $orderItemService;

    public function setUp()
    {
        $this->mockOrderItemRepository = \Mockery::mock('inklabs\kommerce\EntityRepository\OrderItem');

        $this->mockEntityManager = \Mockery::mock('Doctrine\ORM\EntityManager');
        $this->mockEntityManager
            ->shouldReceive('getRepository')
            ->once()
            ->andReturn($this->mockOrderItemRepository);

        $this->orderItemService = new OrderItem($this->mockEntityManager);
    }

    public function testImport()
    {
        $this->mockEntityManager
            ->shouldReceive('persist')
            ->times(3)
            ->andReturnUndefined();

        $this->mockEntityManager
            ->shouldReceive('flush')
            ->once()
            ->andReturnUndefined();

        $iterator = new Lib\CSVIterator(__DIR__ . '/OrderItemTest.csv');
        $importedCount = $this->orderItemService->import($iterator);

        $this->assertSame(37, $importedCount);
    }
}
