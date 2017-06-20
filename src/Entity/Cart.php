<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Exception\InvalidCartActionException;
use inklabs\kommerce\Lib\CartCalculatorInterface;
use Doctrine\Common\Collections\ArrayCollection;
use inklabs\kommerce\Lib\UuidInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

class Cart implements IdEntityInterface
{
    use TimeTrait, IdTrait;

    /** @var string|null */
    protected $sessionId;

    /** @var int|null */
    protected $ip4;

    /** @var User|null */
    protected $user;

    /** @var OrderAddress */
    protected $shippingAddress;

    /** @var ShipmentRate|null */
    protected $shipmentRate;

    /** @var TaxRate|null */
    protected $taxRate;

    /** @var CartItem[]|ArrayCollection */
    protected $cartItems;

    /** @var Coupon[]|ArrayCollection */
    protected $coupons;

    public function __construct(UuidInterface $id = null)
    {
        $this->setId($id);
        $this->setCreated();

        $this->cartItems = new ArrayCollection;
        $this->coupons = new ArrayCollection;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraint('ip4', new Assert\GreaterThanOrEqual([
            'value' => 0,
        ]));

        $metadata->addPropertyConstraint('cartItems', new Assert\Valid);
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user)
    {
        $user->setCart($this);
        $this->user = $user;
    }

    public function getSessionId(): ?string
    {
        return $this->sessionId;
    }

    public function setSessionId(?string $sessionId)
    {
        $this->sessionId = $sessionId;
    }

    public function addCartItem(CartItem $cartItem)
    {
        $this->cartItems->add($cartItem);
    }

    /**
     * @return CartItem[]
     */
    public function getCartItems()
    {
        return $this->cartItems;
    }

    public function deleteCartItem(CartItem $cartItem)
    {
        if (! $this->cartItems->contains($cartItem)) {
            throw new InvalidCartActionException('CartItem missing');
        }

        $this->cartItems->removeElement($cartItem);
    }

    public function addCoupon(Coupon $coupon)
    {
        if ($this->coupons->contains($coupon)) {
            throw new InvalidCartActionException('Duplicate Coupon');
        }

        if (! $this->couponCanCombineWithOtherCoupons($coupon)) {
            throw new InvalidCartActionException('Cannot stack coupon');
        }

        if (! $this->existingCouponsCanCombineWithOtherCoupons()) {
            throw new InvalidCartActionException('Cannot stack coupon');
        }

        $this->coupons->add($coupon);
    }

    public function updateCoupon(int $couponIndex, Coupon $coupon)
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

    private function existingCouponsCanCombineWithOtherCoupons(): bool
    {
        foreach ($this->coupons as $coupon) {
            if (! $coupon->getCanCombineWithOtherCoupons()) {
                return false;
            }
        }
        return true;
    }

    public function removeCoupon(Coupon $coupon)
    {
        if (! $this->coupons->contains($coupon)) {
            throw new InvalidCartActionException('Coupon missing');
        }

        $this->coupons->removeElement($coupon);
    }

    public function totalItems(): int
    {
        return count($this->cartItems);
    }

    public function totalQuantity(): int
    {
        $total = 0;

        foreach ($this->getCartItems() as $item) {
            $total += $item->getQuantity();
        }

        return $total;
    }

    public function getShippingWeight(): int
    {
        $shippingWeight = 0;

        foreach ($this->getCartItems() as $item) {
            $shippingWeight += $item->getShippingWeight();
        }

        return $shippingWeight;
    }

    public function getShippingWeightInPounds(): int
    {
        return (int) ceil($this->getShippingWeight() / 16);
    }

    public function getTotal(CartCalculatorInterface $cartCalculator): CartTotal
    {
        return $cartCalculator->getTotal($this);
    }

    public function getShipmentRate(): ?ShipmentRate
    {
        return $this->shipmentRate;
    }

    public function setShipmentRate(ShipmentRate $shipmentRate = null)
    {
        $this->shipmentRate = $shipmentRate;
    }

    public function getTaxRate(): ?TaxRate
    {
        return $this->taxRate;
    }

    public function setTaxRate(TaxRate $taxRate = null)
    {
        $this->taxRate = $taxRate;
    }

    private function couponCanCombineWithOtherCoupons(Coupon $coupon): bool
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

    public function setIp4(string $ip4)
    {
        $this->ip4 = ip2long($ip4);
    }

    public function getIp4(): ?string
    {
        return long2ip($this->ip4);
    }
}
