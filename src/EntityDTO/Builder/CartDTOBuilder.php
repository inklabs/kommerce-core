<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\EntityDTO\CartDTO;
use inklabs\kommerce\Lib\CartCalculator;
use inklabs\kommerce\Lib\CartCalculatorInterface;

class CartDTOBuilder implements DTOBuilderInterface
{
    use IdDTOBuilderTrait, TimeDTOBuilderTrait;

    /** @var Cart */
    protected $entity;

    /** @var CartDTO */
    protected $entityDTO;

    /** @var DTOBuilderFactoryInterface */
    protected $dtoBuilderFactory;

    public function __construct(Cart $cart, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->entity = $cart;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->entityDTO = new CartDTO;
        $this->setId();
        $this->setTime();
        $this->entityDTO->totalItems     = $this->entity->totalItems();
        $this->entityDTO->totalQuantity  = $this->entity->totalQuantity();
        $this->entityDTO->shippingWeight = $this->entity->getShippingWeight();

        $this->entityDTO->shippingWeightInPounds = $this->entity->getShippingWeightInPounds();

        if ($cart->getShipmentRate() !== null) {
            $this->entityDTO->shipmentRate = $this->dtoBuilderFactory
                ->getShipmentRateDTOBuilder($cart->getShipmentRate())
                ->build();
        }

        if ($cart->getShippingAddress() !== null) {
            $this->entityDTO->shippingAddress = $this->dtoBuilderFactory
                ->getOrderAddressDTOBuilder($cart->getShippingAddress())
                ->build();
        }

        if ($cart->getTaxRate() !== null) {
            $this->entityDTO->taxRate = $this->dtoBuilderFactory
                ->getTaxRateDTOBuilder($cart->getTaxRate())
                ->build();
        }

        if ($cart->getUser() !== null) {
            $this->entityDTO->user = $this->dtoBuilderFactory
                ->getUserDTOBuilder($cart->getUser())
                ->build();
        }
    }

    /**
     * @return static
     */
    public function withCartTotal(CartCalculatorInterface $cartCalculator)
    {
        $this->entityDTO->cartTotal = $this->dtoBuilderFactory
            ->getCartTotalDTOBuilder($this->entity->getTotal($cartCalculator))
            ->withAllData()
            ->build();

        return $this;
    }

    /**
     * @return static
     */
    public function withCartItems(CartCalculator $cartCalculator)
    {
        foreach ($this->entity->getCartItems() as $cartItem) {
            $this->entityDTO->cartItems[] = $this->dtoBuilderFactory
                ->getCartItemDTOBuilder($cartItem)
                ->withAllData($cartCalculator->getPricing())
                ->build();
        }

        return $this;
    }

    /**
     * @return static
     */
    public function withCoupons()
    {
        foreach ($this->entity->getCoupons() as $key => $coupon) {
            $this->entityDTO->coupons[$key] = $this->dtoBuilderFactory
                ->getCouponDTOBuilder($coupon)
                ->build();
        }

        return $this;
    }

    /**
     * @return static
     */
    public function withAllData(CartCalculator $cartCalculator)
    {
        return $this
            ->withCartTotal($cartCalculator)
            ->withCartItems($cartCalculator)
            ->withCoupons();
    }

    protected function preBuild()
    {
    }

    public function build()
    {
        $this->preBuild();
        unset($this->entity);
        return $this->entityDTO;
    }
}
