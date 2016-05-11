<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\EntityRepository\OrderItemRepositoryInterface;
use Mockery;
use inklabs\kommerce\tests\Helper\Entity\DummyData;

class MockRepository
{
    /** @var DummyData */
    protected $dummyData;

    public function __construct(DummyData $dummyData)
    {
        $this->dummyData = $dummyData;
    }

    /**
     * @param string $className
     * @return Mockery\Mock
     */
    protected function getMockeryMock($className)
    {
        return Mockery::mock($className);
    }

    /**
     * @return OrderItemRepositoryInterface | Mockery\Mock
     */
    public function getOrderItemRepository()
    {
        $repository = $this->getMockeryMock(OrderItemRepositoryInterface::class);

        $repository
            ->shouldReceive('findOneById')
            ->with(1)
            ->andReturn($this->dummyData->getOrderitem());

        return $repository;
    }
}
