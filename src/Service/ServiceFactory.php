<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Lib\CartCalculatorInterface;
use inklabs\kommerce\EntityRepository\RepositoryFactory;
use inklabs\kommerce\Lib\Event\EventDispatcherInterface;
use inklabs\kommerce\Lib\FileManagerInterface;
use inklabs\kommerce\Lib\PaymentGateway\PaymentGatewayInterface;
use inklabs\kommerce\Lib\ReferenceNumber\HashSegmentReferenceNumberGenerator;
use inklabs\kommerce\Lib\ReferenceNumber\ReferenceNumberGeneratorInterface;
use inklabs\kommerce\Lib\ShipmentGateway\ShipmentGatewayInterface;
use inklabs\kommerce\Service\Import\ImportOrderItemServiceInterface;
use inklabs\kommerce\Service\Import\ImportOrderServiceInterface;
use inklabs\kommerce\Service\Import\ImportPaymentServiceInterface;
use inklabs\kommerce\Service\Import\ImportUserServiceInterface;

class ServiceFactory
{
    /** @var CartCalculatorInterface */
    private $cartCalculator;

    /** @var RepositoryFactory */
    private $repositoryFactory;

    /** @var EventDispatcherInterface */
    private $eventDispatcher;

    /** @var PaymentGatewayInterface */
    private $paymentGateway;

    /** @var ShipmentGatewayInterface */
    private $shipmentGateway;

    /** @var FileManagerInterface */
    private $fileManager;

    public function __construct(
        RepositoryFactory $repositoryFactory,
        CartCalculatorInterface $cartCalculator,
        EventDispatcherInterface $eventDispatcher,
        PaymentGatewayInterface $paymentGateway,
        ShipmentGatewayInterface $shipmentGateway,
        FileManagerInterface $fileManager
    ) {
        $this->repositoryFactory = $repositoryFactory;
        $this->cartCalculator = $cartCalculator;
        $this->eventDispatcher = $eventDispatcher;
        $this->paymentGateway = $paymentGateway;
        $this->shipmentGateway = $shipmentGateway;
        $this->fileManager = $fileManager;
    }

    public function getAttachmentService(): AttachmentServiceInterface
    {
        return new AttachmentService(
            $this->repositoryFactory->getAttachmentRepository(),
            $this->getFileManager(),
            $this->repositoryFactory->getOrderItemRepository(),
            $this->repositoryFactory->getProductRepository(),
            $this->repositoryFactory->getUserRepository()
        );
    }

    public function getCart(): CartServiceInterface
    {
        return new CartService(
            $this->repositoryFactory->getCartRepository(),
            $this->repositoryFactory->getCouponRepository(),
            $this->eventDispatcher,
            $this->repositoryFactory->getOptionProductRepository(),
            $this->repositoryFactory->getOptionValueRepository(),
            $this->repositoryFactory->getOrderRepository(),
            $this->repositoryFactory->getProductRepository(),
            $this->shipmentGateway,
            $this->repositoryFactory->getTaxRateRepository(),
            $this->repositoryFactory->getTextOptionRepository(),
            $this->repositoryFactory->getUserRepository(),
            $this->getInventoryService()
        );
    }

    public function getCartCalculator(): CartCalculatorInterface
    {
        return $this->cartCalculator;
    }

    public function getFileManager(): FileManagerInterface
    {
        return $this->fileManager;
    }

    public function getReferenceNumberGenerator(): ReferenceNumberGeneratorInterface
    {
        return new HashSegmentReferenceNumberGenerator($this->repositoryFactory->getOrderRepository());
    }

    public function getImageService(): ImageServiceInterface
    {
        return new ImageService(
            $this->getFileManager(),
            $this->repositoryFactory->getImageRepository(),
            $this->repositoryFactory->getProductRepository(),
            $this->repositoryFactory->getTagRepository()
        );
    }

    public function getImportOrder(): ImportOrderServiceInterface
    {
        return new Import\ImportOrderService(
            $this->repositoryFactory->getOrderRepository(),
            $this->repositoryFactory->getUserRepository()
        );
    }

    public function getImportOrderItem(): ImportOrderItemServiceInterface
    {
        return new Import\ImportOrderItemService(
            $this->repositoryFactory->getOrderRepository(),
            $this->repositoryFactory->getOrderItemRepository(),
            $this->repositoryFactory->getProductRepository()
        );
    }

    public function getImportPayment(): ImportPaymentServiceInterface
    {
        return new Import\ImportPaymentService(
            $this->repositoryFactory->getOrderRepository(),
            $this->repositoryFactory->getPaymentRepository()
        );
    }

    public function getImportUser(): ImportUserServiceInterface
    {
        return new Import\ImportUserService($this->repositoryFactory->getUserRepository());
    }

    public function getInventoryService(): InventoryServiceInterface
    {
        return new InventoryService(
            $this->repositoryFactory->getInventoryLocationRepository(),
            $this->repositoryFactory->getInventoryTransactionRepository()
        );
    }

    public function getOrder(): OrderServiceInterface
    {
        return new OrderService(
            $this->eventDispatcher,
            $this->getInventoryService(),
            $this->repositoryFactory->getOrderRepository(),
            $this->repositoryFactory->getOrderItemRepository(),
            $this->paymentGateway,
            $this->repositoryFactory->getProductRepository(),
            $this->shipmentGateway,
            $this->getReferenceNumberGenerator()
        );
    }

    public function getShipmentGateway(): ShipmentGatewayInterface
    {
        return $this->shipmentGateway;
    }

    public function getUser(): UserServiceInterface
    {
        return new UserService(
            $this->repositoryFactory->getUserRepository(),
            $this->repositoryFactory->getUserLoginRepository(),
            $this->repositoryFactory->getUserTokenRepository(),
            $this->eventDispatcher
        );
    }
}
