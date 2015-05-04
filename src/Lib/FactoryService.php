<?php
namespace inklabs\kommerce\Lib;

use inklabs\kommerce\Service;
use inklabs\kommerce\Lib;

class FactoryService
{
    /** @var Lib\Pricing */
    private $pricing;

    /** @var FactoryRepository */
    private $factoryRepository;

    public function __construct(
        FactoryRepository $factoryRepository,
        Lib\Pricing $pricing = null
    ) {
        $this->pricing = $pricing;
        $this->factoryRepository = $factoryRepository;
    }

    /**
     * @param FactoryRepository $factoryRepository
     * @param Lib\Pricing $pricing
     * @return self
     */
    public static function getInstance(
        FactoryRepository $factoryRepository,
        Lib\Pricing $pricing = null
    ) {
        static $factoryService = null;

        if ($factoryService === null) {
            $factoryService = new static($factoryRepository, $pricing);
        }

        return $factoryService;
    }

    /**
     * @return Service\Cart
     */
    public function getCart()
    {
        $cartRepository = $this->factoryRepository->getCart();
        $productRepository = $this->factoryRepository->getProduct();
        $optionProductRepository = $this->factoryRepository->getOptionProduct();
        $optionValueRepository = $this->factoryRepository->getOptionValue();
        $textOptionRepository = $this->factoryRepository->getTextOption();
        $couponRepository = $this->factoryRepository->getCoupon();
        $orderRepository = $this->factoryRepository->getOrder();
        $userRepository = $this->factoryRepository->getUser();

        $cartService = new Service\Cart(
            $cartRepository,
            $productRepository,
            $optionProductRepository,
            $optionValueRepository,
            $textOptionRepository,
            $couponRepository,
            $orderRepository,
            $userRepository,
            $this->pricing
        );

        return $cartService;
    }

    /**
     * @return Service\CatalogPromotion
     */
    public function getCatalogPromotion()
    {
        $catalogPromotionRepository = $this->factoryRepository->getCatalogPromotion();
        $catalogPromotionService = new Service\CatalogPromotion($catalogPromotionRepository);
        return $catalogPromotionService;
    }

    /**
     * @return Service\Coupon
     */
    public function getCoupon()
    {
        $couponRepository = $this->factoryRepository->getCoupon();
        $couponService = new Service\Coupon($couponRepository);
        return $couponService;
    }

    /**
     * @return Service\Order
     */
    public function getOrder()
    {
        $orderRepository = $this->factoryRepository->getOrder();
        $orderService = new Service\Order($orderRepository);
        return $orderService;
    }

    /**
     * @return Service\Product
     */
    public function getProduct()
    {
        $productRepository = $this->factoryRepository->getProduct();
        $tagRepository = $this->factoryRepository->getTag();
        $productService = new Service\Product($productRepository, $tagRepository, $this->pricing);
        return $productService;
    }

    /**
     * @return Service\Tag
     */
    public function getTag()
    {
        $tagRepository = $this->factoryRepository->getTag();
        $tagService = new Service\Tag($tagRepository, $this->pricing);
        return $tagService;
    }

    /**
     * @return Service\TaxRate
     */
    public function getTaxRate()
    {
        $taxRateRepository = $this->factoryRepository->getTaxRate();
        $taxRateService = new Service\TaxRate($taxRateRepository);
        return $taxRateService;
    }

    /**
     * @return Service\User
     */
    public function getUser()
    {
        $userRepository = $this->factoryRepository->getUser();
        $userLoginRepository = $this->factoryRepository->getUserLogin();
        $userService = new Service\User($userRepository, $userLoginRepository);
        return $userService;
    }
}
