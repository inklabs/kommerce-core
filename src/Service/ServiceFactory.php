<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Lib\CartCalculatorInterface;
use inklabs\kommerce\EntityRepository\RepositoryFactory;
use inklabs\kommerce\Lib\Event\EventDispatcherInterface;
use inklabs\kommerce\Lib\FileManagerInterface;
use inklabs\kommerce\Lib\PaymentGateway\PaymentGatewayInterface;
use inklabs\kommerce\Lib\ShipmentGateway\ShipmentGatewayInterface;

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

    /**
     * @return AttachmentService
     */
    public function getAttachmentService()
    {
        return new AttachmentService(
            $this->repositoryFactory->getAttachmentRepository(),
            $this->getFileManager(),
            $this->getOrder()
        );
    }

    /**
     * @return AttributeService
     */
    public function getAttribute()
    {
        return new AttributeService($this->repositoryFactory->getAttributeRepository());
    }

    /**
     * @return AttributeValueService
     */
    public function getAttributeValue()
    {
        return new AttributeValueService($this->repositoryFactory->getAttributeValueRepository());
    }

    /**
     * @return CartService
     */
    public function getCart()
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

    public function getCartCalculator()
    {
        return $this->cartCalculator;
    }

    /**
     * @return CartPriceRuleService
     */
    public function getCartPriceRule()
    {
        return new CartPriceRuleService($this->repositoryFactory->getCartPriceRuleRepository());
    }

    /**
     * @return CatalogPromotionService
     */
    public function getCatalogPromotion()
    {
        return new CatalogPromotionService($this->repositoryFactory->getCatalogPromotionRepository());
    }

    /**
     * @return CouponService
     */
    public function getCoupon()
    {
        return new CouponService($this->repositoryFactory->getCouponRepository());
    }

    /**
     * @return FileManagerInterface
     */
    public function getFileManager()
    {
        return $this->fileManager;
    }

    /**
     * @return ImageService
     */
    public function getImageService()
    {
        return new ImageService(
            $this->repositoryFactory->getImageRepository(),
            $this->repositoryFactory->getProductRepository(),
            $this->repositoryFactory->getTagRepository()
        );
    }

    /**
     * @return Import\ImportOrderService
     */
    public function getImportOrder()
    {
        return new Import\ImportOrderService(
            $this->repositoryFactory->getOrderRepository(),
            $this->repositoryFactory->getUserRepository()
        );
    }

    /**
     * @return Import\ImportOrderItemService
     */
    public function getImportOrderItem()
    {
        return new Import\ImportOrderItemService(
            $this->repositoryFactory->getOrderRepository(),
            $this->repositoryFactory->getOrderItemRepository(),
            $this->repositoryFactory->getProductRepository()
        );
    }

    /**
     * @return Import\ImportPaymentService
     */
    public function getImportPayment()
    {
        return new Import\ImportPaymentService(
            $this->repositoryFactory->getOrderRepository(),
            $this->repositoryFactory->getPaymentRepository()
        );
    }

    /**
     * @return Import\ImportUserService
     */
    public function getImportUser()
    {
        return new Import\ImportUserService($this->repositoryFactory->getUserRepository());
    }

    public function getInventoryService()
    {
        return new InventoryService(
            $this->repositoryFactory->getInventoryLocationRepository(),
            $this->repositoryFactory->getInventoryTransactionRepository(),
            1
        );
    }

    /**
     * @return OptionService
     */
    public function getOption()
    {
        return new OptionService($this->repositoryFactory->getOptionRepository());
    }

    /**
     * @return OrderService
     */
    public function getOrder()
    {
        return new OrderService(
            $this->eventDispatcher,
            $this->getInventoryService(),
            $this->repositoryFactory->getOrderRepository(),
            $this->repositoryFactory->getOrderItemRepository(),
            $this->paymentGateway,
            $this->repositoryFactory->getProductRepository(),
            $this->shipmentGateway
        );
    }

    /**
     * @return ProductService
     */
    public function getProduct()
    {
        return new ProductService(
            $this->repositoryFactory->getProductRepository(),
            $this->repositoryFactory->getTagRepository(),
            $this->repositoryFactory->getImageRepository()
        );
    }

    /**
     * @return ShipmentGatewayInterface
     */
    public function getShipmentGateway()
    {
        return $this->shipmentGateway;
    }

    /**
     * @return TagService
     */
    public function getTagService()
    {
        return new TagService(
            $this->repositoryFactory->getTagRepository(),
            $this->repositoryFactory->getImageRepository(),
            $this->repositoryFactory->getOptionRepository()
        );
    }

    /**
     * @return TaxRateService
     */
    public function getTaxRate()
    {
        return new TaxRateService($this->repositoryFactory->getTaxRateRepository());
    }

    /**
     * @return UserService
     */
    public function getUser()
    {
        return new UserService(
            $this->repositoryFactory->getUserRepository(),
            $this->repositoryFactory->getUserLoginRepository(),
            $this->repositoryFactory->getUserTokenRepository(),
            $this->eventDispatcher
        );
    }
}
