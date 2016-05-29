<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\EntityDTO\Builder\CartDTOBuilder;
use inklabs\kommerce\Exception\InvalidCartActionException;
use inklabs\kommerce\Lib\CartCalculatorInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class Cart implements IdEntityInterface, ValidationInterface
{
    use TimeTrait, IdTrait;

    /** @var string */
    protected $sessionId;

    /** @var int */
    protected $ip4;

    /** @var User */
    protected $user;

    /** @var OrderAddress */
    protected $shippingAddress;

    /** @var ShipmentRate */
    protected $shipmentRate;

    /** @var TaxRate */
    protected $taxRate;

    /** @var CartItem[] | ArrayCollection */
    protected $cartItems;

    /** @var Coupon[] | ArrayCollection */
    protected $coupons;

    public function __construct()
    {
        $this->setId();
        $this->setCreated();

        $this->cartItems = new ArrayCollection;
        $this->coupons = new ArrayCollection;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('ip4', new Assert\NotBlank);
        $metadata->addPropertyConstraint('ip4', new Assert\GreaterThanOrEqual([
            'value' => 0,
        ]));

        $metadata->addPropertyConstraint('cartItems', new Assert\Valid);
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser(User $user)
    {
        $user->setCart($this);
        $this->user = $user;
    }

    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * @param string | null $sessionId
     */
    public function setSessionId($sessionId)
    {
        if ($sessionId !== null) {
            $sessionId = (string) $sessionId;
        }

        $this->sessionId = $sessionId;
    }

    /**
     * @param CartItem $cartItem
     * @return int
     */
    public function addCartItem(CartItem $cartItem)
    {
        $cartItem->setCart($this);
        $this->cartItems->add($cartItem);

        $this->cartItems->last();
        $cartItemIndex = $this->cartItems->key();
        return $cartItemIndex;
    }

    /**
     * @param int $cartItemIndex
     * @return CartItem
     * @throws InvalidCartActionException
     */
    public function getCartItem($cartItemIndex)
    {
        if (! isset($this->cartItems[$cartItemIndex])) {
            throw new InvalidCartActionException('CartItem not found');
        }

        return $this->cartItems[$cartItemIndex];
    }

    /**
     * @return CartItem[]
     */
    public function getCartItems()
    {
        return $this->cartItems;
    }

    public function deleteCartItem($cartItemIndex)
    {
        if (! $this->cartItems->offsetExists($cartItemIndex)) {
            throw new InvalidCartActionException('CartItem missing');
        }

        $this->cartItems->remove($cartItemIndex);
    }

    /**
     * @param Coupon $coupon
     * @return int
     * @throws InvalidCartActionException
     */
    public function addCoupon(Coupon $coupon)
    {
        if ($this->isExistingCoupon($coupon)) {
            throw new InvalidCartActionException('Duplicate Coupon');
        }

        if (! $this->couponCanCombineWithOtherCoupons($coupon)) {
            throw new InvalidCartActionException('Cannot stack coupon');
        }

        if (! $this->existingCouponsCanCombineWithOtherCoupons()) {
            throw new InvalidCartActionException('Cannot stack coupon');
        }

        $this->coupons->add($coupon);

        $couponIndex = $this->coupons->key();
        return $couponIndex;
    }

    public function updateCoupon($couponIndex, Coupon $coupon)
    {
        $this->coupons->set($couponIndex, $coupon);
    }

    /**
     * @return Coupon[]
     */
    public function getCoupons()
    {
        return $this->coupons;
    }

    private function isExistingCoupon(Coupon $addedCoupon)
    {
        foreach ($this->coupons as $coupon) {
            if ($coupon->getId() === $addedCoupon->getId()) {
                return true;
            }
        }

        return false;
    }

    private function existingCouponsCanCombineWithOtherCoupons()
    {
        foreach ($this->coupons as $coupon) {
            if (! $coupon->getCanCombineWithOtherCoupons()) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param int $key
     * @throws InvalidCartActionException
     */
    public function removeCoupon($key)
    {
        if (! isset($this->coupons[$key])) {
            throw new InvalidCartActionException('Coupon missing');
        }

        unset($this->coupons[$key]);
    }

    public function totalItems()
    {
        return count($this->cartItems);
    }

    public function totalQuantity()
    {
        $total = 0;

        foreach ($this->getCartItems() as $item) {
            $total += $item->getQuantity();
        }

        return $total;
    }

    public function getShippingWeight()
    {
        $shippingWeight = 0;

        foreach ($this->getCartItems() as $item) {
            $shippingWeight += $item->getShippingWeight();
        }

        return $shippingWeight;
    }

    public function getShippingWeightInPounds()
    {
        return (int) ceil($this->getShippingWeight() / 16);
    }

    public function getTotal(CartCalculatorInterface $cartCalculator)
    {
        return $cartCalculator->getTotal($this);
    }

    public function getShipmentRate()
    {
        return $this->shipmentRate;
    }

    public function setShipmentRate(ShipmentRate $shipmentRate = null)
    {
        $this->shipmentRate = $shipmentRate;
    }

    public function getTaxRate()
    {
        return $this->taxRate;
    }

    public function setTaxRate(TaxRate $taxRate = null)
    {
        $this->taxRate = $taxRate;
    }

    public function getDTOBuilder()
    {
        return new CartDTOBuilder($this);
    }

    /**
     * @param Coupon $coupon
     * @return bool
     */
    private function couponCanCombineWithOtherCoupons(Coupon $coupon)
    {
        return ! ($this->coupons->count() > 0 && ! $coupon->getCanCombineWithOtherCoupons());
    }

    public function setShippingAddress(OrderAddress $shippingAddress)
    {
        $this->shippingAddress = $shippingAddress;
    }

    public function getShippingAddress()
    {
        return $this->shippingAddress;
    }

    /**
     * @param string $ip4
     */
    public function setIp4($ip4)
    {
        $this->ip4 = (int) ip2long($ip4);
    }

    public function getIp4()
    {
        return long2ip($this->ip4);
    }
}
