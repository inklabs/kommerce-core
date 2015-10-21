<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\EntityRepository\RepositoryFactoryInterface;
use inklabs\kommerce\Lib\CartCalculatorInterface;
use inklabs\kommerce\EntityRepository\RepositoryFactory;
use inklabs\kommerce\Lib\Event\EventDispatcherInterface;

class ServiceFactory
{
    /** @var CartCalculatorInterface */
    protected $cartCalculator;

    /** @var RepositoryFactory */
    protected $repositoryFactory;

    /** @var EventDispatcherInterface */
    protected $eventDispatcher;

    public function __construct(
        RepositoryFactoryInterface $repositoryFactory,
        CartCalculatorInterface $cartCalculator,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->repositoryFactory = $repositoryFactory;
        $this->cartCalculator = $cartCalculator;
        $this->eventDispatcher = $eventDispatcher;
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
            $this->repositoryFactory->getProductRepository(),
            $this->repositoryFactory->getOptionProductRepository(),
            $this->repositoryFactory->getOptionValueRepository(),
            $this->repositoryFactory->getTextOptionRepository(),
            $this->repositoryFactory->getCouponRepository(),
            $this->repositoryFactory->getOrderRepository(),
            $this->repositoryFactory->getUserRepository(),
            $this->cartCalculator,
            $this->eventDispatcher
        );
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
            $this->repositoryFactory->getOrderRepository(),
            $this->repositoryFactory->getProductRepository()
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
     * @return TagService
     */
    public function getTagService()
    {
        return new TagService($this->repositoryFactory->getTagRepository());
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
