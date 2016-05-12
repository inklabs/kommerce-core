<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\EntityRepository\AttributeRepositoryInterface;
use inklabs\kommerce\EntityRepository\ImageRepositoryInterface;
use inklabs\kommerce\EntityRepository\OrderItemRepositoryInterface;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;
use inklabs\kommerce\EntityRepository\TagRepositoryInterface;
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
     * @return AttributeRepositoryInterface | Mockery\Mock
     */
    public function getAttributeRepository()
    {
        $repository = $this->getMockeryMock(AttributeRepositoryInterface::class);
        return $repository;
    }

    /**
     * @return ImageRepositoryInterface | Mockery\Mock
     */
    public function getImageRepository()
    {
        $repository = $this->getMockeryMock(ImageRepositoryInterface::class);
        return $repository;
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

    /**
     * @return ProductRepositoryInterface | Mockery\Mock
     */
    public function getProductRepository()
    {
        $repository = $this->getMockeryMock(ProductRepositoryInterface::class);

        $product = $this->dummyData->getProduct();
        $product->setId(99);

        $repository->shouldReceive('findOneById')
            ->with($product->getId())
            ->andReturn($product);

        $repository->shouldReceive('getAllProducts')
            ->andReturn([$product]);

        $repository->shouldReceive('getRelatedProductsByIds')
            ->andReturn([$product]);

        $repository->shouldReceive('getProductsByTagId')
            ->andReturn([$product]);

        $repository->shouldReceive('getProductsByIds')
            ->andReturn([$product]);

        $repository->shouldReceive('getAllProductsByIds')
            ->andReturn([$product]);

        $repository->shouldReceive('getRandomProducts')
            ->andReturn([$product]);

        return $repository;
    }

    /**
     * @return TagRepositoryInterface | Mockery\Mock
     */
    public function getTagRepository()
    {
        $repository = $this->getMockeryMock(TagRepositoryInterface::class);
        return $repository;
    }
}
