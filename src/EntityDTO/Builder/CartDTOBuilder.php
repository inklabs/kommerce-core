<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\EntityDTO\CartDTO;
use inklabs\kommerce\Lib\CartCalculator;
use inklabs\kommerce\Lib\CartCalculatorInterface;

class CartDTOBuilder
{
    /** @var Cart */
    protected $cart;

    /** @var CartDTO */
    protected $cartDTO;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(Cart $cart, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->cart = $cart;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->cartDTO = new CartDTO;
        $this->cartDTO->id             = $this->cart->getId();
        $this->cartDTO->totalItems     = $this->cart->totalItems();
        $this->cartDTO->totalQuantity  = $this->cart->totalQuantity();
        $this->cartDTO->shippingWeight = $this->cart->getShippingWeight();
        $this->cartDTO->created        = $this->cart->getCreated();
        $this->cartDTO->updated        = $this->cart->getUpdated();

        $this->cartDTO->shippingWeightInPounds = $this->cart->getShippingWeightInPounds();

        if ($cart->getShipmentRate() !== null) {
            $this->cartDTO->shipmentRate = $this->dtoBuilderFactory
                ->getShipmentRateDTOBuilder($cart->getShipmentRate())
                ->build();
        }

        if ($cart->getShippingAddress() !== null) {
            $this->cartDTO->shippingAddress = $this->dtoBuilderFactory
                ->getOrderAddressDTOBuilder($cart->getShippingAddress())
                ->build();
        }

        if ($cart->getTaxRate() !== null) {
            $this->cartDTO->taxRate = $this->dtoBuilderFactory
                ->getTaxRateDTOBuilder($cart->getTaxRate())
                ->build();
        }

        if ($cart->getUser() !== null) {
            $this->cartDTO->user = $this->dtoBuilderFactory
                ->getUserDTOBuilder($cart->getUser())
                ->build();
        }
    }

    public function withCartTotal(CartCalculatorInterface $cartCalculator)
    {
        $this->cartDTO->cartTotal = $this->dtoBuilderFactory
            ->getCartTotalDTOBuilder($this->cart->getTotal($cartCalculator))
            ->withAllData()
            ->build();

        return $this;
    }

    public function withCartItems(CartCalculator $cartCalculator)
    {
        foreach ($this->cart->getCartItems() as $cartItemIndex => $cartItem) {
            $this->cartDTO->cartItems[$cartItemIndex] = $this->dtoBuilderFactory
                ->getCartItemDTOBuilder($cartItem)
                ->withAllData($cartCalculator->getPricing())
                ->build();
        }

        return $this;
    }

    public function withCoupons()
    {
        foreach ($this->cart->getCoupons() as $key => $coupon) {
            $this->cartDTO->coupons[$key] = $this->dtoBuilderFactory
                ->getCouponDTOBuilder($coupon)
                ->build();
        }

        return $this;
    }

    public function withAllData(CartCalculator $cartCalculator)
    {
        return $this
            ->withCartTotal($cartCalculator)
            ->withCartItems($cartCalculator)
            ->withCoupons();
    }

    public function build()
    {
        return $this->cartDTO;
    }
}
