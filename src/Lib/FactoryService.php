<?php
namespace inklabs\kommerce\Lib;

use inklabs\kommerce\Service;

class FactoryService
{
    /** @var CartCalculatorInterface */
    protected $cartCalculator;

    /** @var FactoryRepository */
    protected $factoryRepository;

    public function __construct(
        FactoryRepository $factoryRepository,
        CartCalculatorInterface $cartCalculator
    ) {
        $this->cartCalculator = $cartCalculator;
        $this->factoryRepository = $factoryRepository;
    }

    /**
     * @param FactoryRepository $factoryRepository
     * @param CartCalculatorInterface $cartCalculator
     * @return FactoryService
     */
    public static function getInstance(
        FactoryRepository $factoryRepository,
        CartCalculatorInterface $cartCalculator
    ) {
        static $factoryService = null;

        if ($factoryService === null) {
            $factoryService = new static($factoryRepository, $cartCalculator);
        }

        return $factoryService;
    }

    /**
     * @return Service\Attribute
     */
    public function getAttribute()
    {
        return new Service\Attribute($this->factoryRepository->getAttributeRepository());
    }

    /**
     * @return Service\AttributeValue
     */
    public function getAttributeValue()
    {
        return new Service\AttributeValue($this->factoryRepository->getAttributeValueRepository());
    }

    /**
     * @return Service\Cart
     */
    public function getCart()
    {
        return new Service\Cart(
            $this->factoryRepository->getCartRepository(),
            $this->factoryRepository->getProductRepository(),
            $this->factoryRepository->getOptionProductRepository(),
            $this->factoryRepository->getOptionValueRepository(),
            $this->factoryRepository->getTextOptionRepository(),
            $this->factoryRepository->getCouponRepository(),
            $this->factoryRepository->getOrderRepository(),
            $this->factoryRepository->getUserRepository(),
            $this->cartCalculator
        );
    }

    /**
     * @return Service\CartPriceRule
     */
    public function getCartPriceRule()
    {
        return new Service\CartPriceRule($this->factoryRepository->getCartPriceRuleRepository());
    }

    /**
     * @return Service\CatalogPromotion
     */
    public function getCatalogPromotion()
    {
        return new Service\CatalogPromotion($this->factoryRepository->getCatalogPromotionRepository());
    }

    /**
     * @return Service\Coupon
     */
    public function getCoupon()
    {
        return new Service\Coupon($this->factoryRepository->getCouponRepository());
    }

    /**
     * @return Service\Image
     */
    public function getImage()
    {
        return new Service\Image(
            $this->factoryRepository->getImageRepository(),
            $this->factoryRepository->getProductRepository()
        );
    }

    /**
     * @return Service\Import\Order
     */
    public function getImportOrder()
    {
        return new Service\Import\Order(
            $this->factoryRepository->getOrderRepository(),
            $this->factoryRepository->getUserRepository()
        );
    }

    /**
     * @return Service\Import\OrderItem
     */
    public function getImportOrderItem()
    {
        return new Service\Import\OrderItem(
            $this->factoryRepository->getOrderRepository(),
            $this->factoryRepository->getOrderItemRepository(),
            $this->factoryRepository->getProductRepository()
        );
    }

    /**
     * @return Service\Import\Payment
     */
    public function getImportPayment()
    {
        return new Service\Import\Payment(
            $this->factoryRepository->getOrderRepository(),
            $this->factoryRepository->getPaymentRepository()
        );
    }

    /**
     * @return Service\Import\User
     */
    public function getImportUser()
    {
        return new Service\Import\User($this->factoryRepository->getUserRepository());
    }

    /**
     * @return Service\Option
     */
    public function getOption()
    {
        return new Service\Option($this->factoryRepository->getOptionRepository());
    }

    /**
     * @return Service\Order
     */
    public function getOrder()
    {
        return new Service\Order(
            $this->factoryRepository->getOrderRepository(),
            $this->factoryRepository->getProductRepository()
        );
    }

    /**
     * @return Service\Product
     */
    public function getProduct()
    {
        return new Service\Product(
            $this->factoryRepository->getProductRepository(),
            $this->factoryRepository->getTagRepository(),
            $this->factoryRepository->getImageRepository()
        );
    }

    /**
     * @return Service\TagService
     */
    public function getTagService()
    {
        return new Service\TagService($this->factoryRepository->getTagRepository());
    }

    /**
     * @return Service\TaxRate
     */
    public function getTaxRate()
    {
        return new Service\TaxRate($this->factoryRepository->getTaxRateRepository());
    }

    /**
     * @return Service\User
     */
    public function getUser()
    {
        return new Service\User(
            $this->factoryRepository->getUserRepository(),
            $this->factoryRepository->getUserLoginRepository()
        );
    }
}
