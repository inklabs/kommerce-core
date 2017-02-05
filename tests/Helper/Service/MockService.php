<?php
namespace inklabs\kommerce\tests\Helper\Service;

use inklabs\kommerce\Lib\FileManagerInterface;
use inklabs\kommerce\Lib\ShipmentGateway\ShipmentGatewayInterface;
use inklabs\kommerce\Service\AttachmentServiceInterface;
use inklabs\kommerce\Service\CartServiceInterface;
use inklabs\kommerce\Service\ImageServiceInterface;
use inklabs\kommerce\Service\Import\ImportOrderItemServiceInterface;
use inklabs\kommerce\Service\Import\ImportOrderServiceInterface;
use inklabs\kommerce\Service\Import\ImportPaymentServiceInterface;
use inklabs\kommerce\Service\Import\ImportUserServiceInterface;
use inklabs\kommerce\Service\InventoryServiceInterface;
use inklabs\kommerce\Service\OrderServiceInterface;
use inklabs\kommerce\Service\ProductServiceInterface;
use inklabs\kommerce\Service\TaxRateServiceInterface;
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
     * @return AttachmentServiceInterface|Mockery\Mock
     */
    public function getAttachmentService()
    {
        $attachmentService = $this->getMockeryMock(AttachmentServiceInterface::class);
        return $attachmentService;
    }

    /**
     * @return CartServiceInterface|Mockery\Mock
     */
    public function getCartService()
    {
        $cart = $this->dummyData->getCart();

        $cartService = $this->getMockeryMock(CartServiceInterface::class);
        $cartService->shouldReceive('findOneById')
            ->andReturn($cart);

        $cartService->shouldReceive('findBySession')
            ->andReturn($cart);

        $cartService->shouldReceive('findByUser')
            ->andReturn($cart);

        return $cartService;
    }

    /**
     * @return FileManagerInterface|Mockery\Mock
     */
    public function getFileManager()
    {
        $service = $this->getMockeryMock(FileManagerInterface::class);
        return $service;
    }

    /**
     * @return InventoryServiceInterface|Mockery\Mock
     */
    public function getInventoryService()
    {
        $inventoryService = $this->getMockeryMock(InventoryServiceInterface::class);
        return $inventoryService;
    }

    /**
     * @return ImageServiceInterface|Mockery\Mock
     */
    public function getImageService()
    {
        $image = $this->dummyData->getImage();

        $service = $this->getMockeryMock(ImageServiceInterface::class);
        $service->shouldReceive('findOneById')
            ->andReturn($image);

        return $service;
    }
    /**
     * @return ImportOrderServiceInterface|Mockery\Mock
     */
    public function getImportOrderService()
    {
        $importOrderService = $this->getMockeryMock(ImportOrderServiceInterface::class);
        return $importOrderService;
    }

    /**
     * @return ImportOrderItemServiceInterface|Mockery\Mock
     */
    public function getImportOrderItemService()
    {
        $importOrderService = $this->getMockeryMock(ImportOrderItemServiceInterface::class);
        return $importOrderService;
    }

    /**
     * @return ImportPaymentServiceInterface|Mockery\Mock
     */
    public function getImportPaymentService()
    {
        $importPaymentService = $this->getMockeryMock(ImportPaymentServiceInterface::class);
        return $importPaymentService;
    }

    /**
     * @return ImportUserServiceInterface|Mockery\Mock
     */
    public function getImportUserService()
    {
        $importUserService = $this->getMockeryMock(ImportUserServiceInterface::class);
        return $importUserService;
    }

    /**
     * @return OrderServiceInterface|Mockery\Mock
     */
    public function getOrderService()
    {
        $order = $this->dummyData->getOrder();

        $service = $this->getMockeryMock(OrderServiceInterface::class);

        $service->shouldReceive('findOneById')
            ->andReturn($order);

        $service->shouldReceive('getLatestOrders')
            ->andReturn([$order]);

        return $service;
    }

    /**
     * @return ProductServiceInterface|Mockery\Mock
     */
    public function getProductService()
    {
        $product = $this->dummyData->getProduct();

        $service = $this->getMockeryMock(ProductServiceInterface::class);
        $service->shouldReceive('findOneById')
            ->andReturn($product);

        $service->shouldReceive('getRelatedProductsByIds')
            ->andReturn([$product]);

        $service->shouldReceive('getAllProducts')
            ->andReturn([$product]);

        return $service;
    }

    /**
     * @return ShipmentGatewayInterface|Mockery\Mock
     */
    public function getShipmentGateway()
    {
        $shipmentRate = $this->dummyData->getShipmentRate(225);

        $shipmentGateway = $this->getMockeryMock(ShipmentGatewayInterface::class);
        $shipmentGateway->shouldReceive('getRates')
            ->andReturn([$shipmentRate]);

        return $shipmentGateway;
    }

    /**
     * @return TaxRateServiceInterface|Mockery\Mock
     */
    public function getTaxRateService()
    {
        $taxRate = $this->dummyData->getTaxRate();
        $service = $this->getMockeryMock(TaxRateServiceInterface::class);
        $service->shouldReceive('findOneById')
            ->andReturn($taxRate);

        $service->shouldReceive('findByZip5AndState')
            ->andReturn($taxRate);

        $service->shouldReceive('findAll')
            ->andReturn([$taxRate]);

        return $service;
    }

    /**
     * @return UserServiceInterface|Mockery\Mock
     */
    public function getUserService()
    {
        $user = $this->dummyData->getUser();

        $service = $this->getMockeryMock(UserServiceInterface::class);
        $service->shouldReceive('findOneById')
            ->andReturn($user);

        $service->shouldReceive('findOneByEmail')
            ->andReturn($user);

        $service->shouldReceive('getAllUsers')
            ->andReturn([$user]);

        return $service;
    }
}
