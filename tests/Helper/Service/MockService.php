<?php
namespace inklabs\kommerce\tests\Helper\Service;

use inklabs\kommerce\Lib\ShipmentGateway\ShipmentGatewayInterface;
use inklabs\kommerce\Service\InventoryServiceInterface;
use inklabs\kommerce\Service\OrderServiceInterface;
use inklabs\kommerce\Service\ProductServiceInterface;
use inklabs\kommerce\Service\TagServiceInterface;
use inklabs\kommerce\Service\UserServiceInterface;
use inklabs\kommerce\tests\Helper\Entity\DummyData;
use Mockery;

class MockService
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
     * @return InventoryServiceInterface | Mockery\Mock
     */
    public function getInventoryService()
    {
        $inventoryService = $this->getMockeryMock(InventoryServiceInterface::class);

        return $inventoryService;
    }

    /**
     * @return ShipmentGatewayInterface | Mockery\Mock
     */
    public function getShipmentGateway()
    {
        $shipmentGateway = $this->getMockeryMock(ShipmentGatewayInterface::class);
        $shipmentGateway->shouldReceive('getRates')
            ->andReturn([
                $this->dummyData->getShipmentRate(225)
            ]);

        return $shipmentGateway;
    }

    /**
     * @return TagServiceInterface | Mockery\Mock
     */
    public function getTagService()
    {
        $tagService = $this->getMockeryMock(TagServiceInterface::class);
        $tagService->shouldReceive('findOneById')
            ->andReturn(
                $this->dummyData->getTag()
            );

        $tagService->shouldReceive('getAllTags')
            ->andReturn([
                $this->dummyData->getTag()
            ]);

        return $tagService;
    }

    /**
     * @return OrderServiceInterface | Mockery\Mock
     */
    public function getOrderService()
    {
        $orderService = $this->getMockeryMock(OrderServiceInterface::class);

        return $orderService;
    }

    /**
     * @return ProductServiceInterface | Mockery\Mock
     */
    public function getProductService()
    {
        $productService = $this->getMockeryMock(ProductServiceInterface::class);
        $productService->shouldReceive('findOneById')
            ->andReturn(
                $this->dummyData->getProduct()
            );

        return $productService;
    }

    /**
     * @return UserServiceInterface | Mockery\Mock
     */
    public function getUserService()
    {
        $userService = $this->getMockeryMock(UserServiceInterface::class);
        $userService->shouldReceive('loginWithToken')
            ->andReturn(
                $this->dummyData->getUser()
            );

        return $userService;
    }
}
