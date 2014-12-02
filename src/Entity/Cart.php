<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Service\Pricing;
use Exception;

class Cart
{
    /* @var CartItem[] */
    protected $items = [];

    /* @var Coupon[] */
    protected $coupons = [];

    /* @var CartPriceRule[] */
    protected $cartPriceRules = [];

    public function addItem(Product $product, $quantity)
    {
        $this->items[] = new CartItem($product, $quantity);

        end($this->items);
        $cartItemId = key($this->items);

        $this->items[$cartItemId]->setId($cartItemId);

        return $cartItemId;
    }

    /**
     * @return CartItem|null
     */
    public function getItem($id)
    {
        if (isset($this->items[$id])) {
            return $this->items[$id];
        } else {
            return null;
        }
    }

    /**
     * @return CartItem[]
     */
    public function getItems()
    {
        return $this->items;
    }

    public function deleteItem($id)
    {
        if (isset($this->items[$id])) {
            unset($this->items[$id]);
        } else {
            throw new \Exception('Item missing');
        }
    }

    public function addCoupon(Coupon $coupon)
    {
        if (! $this->canAddCoupon($coupon)) {
            throw new Exception('Unable to add coupon');
        }

        $this->coupons[] = $coupon;
    }

    public function updateCoupon($id, Coupon $coupon)
    {
        $this->coupons[$id] = $coupon;
    }

    /**
     * @return Coupon[]
     */
    public function getCoupons()
    {
        return $this->coupons;
    }

    private function canAddCoupon(Coupon $addedCoupon)
    {
        if ($this->isExistingCoupon($addedCoupon)) {
            return false;
        }

        if ($addedCoupon->getCanCombineWithOtherCoupons()) {
            return true;
        }

        if ($this->existingCouponsCannotCombineWithOtherCoupons($addedCoupon)) {
            return false;
        }

        return true;
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

    private function existingCouponsCannotCombineWithOtherCoupons(Coupon $addedCoupon)
    {
        foreach ($this->coupons as $coupon) {
            if (! $coupon->getCanCombineWithOtherCoupons()) {
                return true;
            }
        }
        return false;
    }

    public function removeCoupon($key)
    {
        if (! isset($this->coupons[$key])) {
            throw new Exception('Coupon missing');
        }

        unset($this->coupons[$key]);
    }

    public function addCartPriceRule(CartPriceRule $cartPriceRule)
    {
        $this->cartPriceRules[] = $cartPriceRule;
    }

    public function getCartPriceRules()
    {
        return $this->cartPriceRules;
    }

    public function totalItems()
    {
        return count($this->items);
    }

    public function totalQuantity()
    {
        $total = 0;

        foreach ($this->items as $item) {
            $total += $item->getQuantity();
        }

        return $total;
    }

    public function getShippingWeight()
    {
        $shippingWeight = 0;

        foreach ($this->items as $item) {
            $shippingWeight += $item->getShippingWeight();
        }

        return $shippingWeight;
    }

    /**
     * @return CartTotal
     */
    public function getTotal(Pricing $pricing, Shipping\Rate $shippingRate = null, TaxRate $taxRate = null)
    {
        $cartCalculator = new CartCalculator($this);
        return $cartCalculator->getTotal($pricing, $shippingRate, $taxRate);
    }
}
