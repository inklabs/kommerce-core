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
     * @return Service\Attribute
     */
    public function getAttribute()
    {
        return new Service\Attribute($this->factoryRepository->getAttribute());
    }

    /**
     * @return Service\AttributeValue
     */
    public function getAttributeValue()
    {
        return new Service\AttributeValue($this->factoryRepository->getAttributeValue());
    }

    /**
     * @return Service\Cart
     */
    public function getCart()
    {
        return new Service\Cart(
            $this->factoryRepository->getCart(),
            $this->factoryRepository->getProduct(),
            $this->factoryRepository->getOptionProduct(),
            $this->factoryRepository->getOptionValue(),
            $this->factoryRepository->getTextOption(),
            $this->factoryRepository->getCoupon(),
            $this->factoryRepository->getOrder(),
            $this->factoryRepository->getUser(),
            $this->pricing
        );
    }

    /**
     * @return Service\CartPriceRule
     */
    public function getCartPriceRule()
    {
        return new Service\CartPriceRule($this->factoryRepository->getCartPriceRule());
    }

    /**
     * @return Service\CatalogPromotion
     */
    public function getCatalogPromotion()
    {
        return new Service\CatalogPromotion($this->factoryRepository->getCatalogPromotion());
    }

    /**
     * @return Service\Coupon
     */
    public function getCoupon()
    {
        return new Service\Coupon($this->factoryRepository->getCoupon());
    }

    /**
     * @return Service\Image
     */
    public function getImage()
    {
        return new Service\Image(
            $this->factoryRepository->getImage(),
            $this->factoryRepository->getProduct()
        );
    }

    /**
     * @return Service\Order
     */
    public function getOrder()
    {
        return new Service\Order($this->factoryRepository->getOrder());
    }

    /**
     * @return Service\Product
     */
    public function getProduct()
    {
        return new Service\Product(
            $this->factoryRepository->getProduct(),
            $this->factoryRepository->getTag(),
            $this->pricing
        );
    }

    /**
     * @return Service\Tag
     */
    public function getTag()
    {
        return new Service\Tag(
            $this->factoryRepository->getTag(),
            $this->pricing
        );
    }

    /**
     * @return Service\TaxRate
     */
    public function getTaxRate()
    {
        return new Service\TaxRate($this->factoryRepository->getTaxRate());
    }

    /**
     * @return Service\User
     */
    public function getUser()
    {
        return new Service\User($this->factoryRepository->getUser(), $this->factoryRepository->getUserLogin());
    }
}
