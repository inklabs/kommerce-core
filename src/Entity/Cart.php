<?php
namespace inklabs\kommerce\Entity;

use inklabs\kommerce\Service\Pricing;
use Exception;

class Cart
{
    use Accessor\Created;

    /* @var CartItem[] */
    protected $items = [];

    /* @var Coupon[] */
    protected $coupons = [];

    public function __construct()
    {
        $this->setCreated();
    }

    /**
     * @param Product $product
     * @param int $quantity
     * @param Product[] $optionProducts
     * @return int
     */
    public function addItem(Product $product, $quantity, $optionProducts = null)
    {
        $cartItem = new CartItem($product, $quantity);

        if ($optionProducts !== null) {
            foreach ($optionProducts as $optionProduct) {
                $cartItem->addOptionProduct($optionProduct);
            }
        }

        $this->items[] = $cartItem;

        $cartItemId = $this->getLastItemId();

        $this->items[$cartItemId]->setId($cartItemId);

        return $cartItemId;
    }

    /**
     * @return int
     */
    private function getLastItemId()
    {
        end($this->items);
        return key($this->items);
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

        end($this->coupons);
        $couponId = key($this->coupons);
        return $couponId;
    }

    public function updateCoupon($id, Coupon $coupon)
    {
        $this->coupons[$id] = $coupon;
    }

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

    /**
     * @param int $key
     * @throws Exception
     */
    public function removeCoupon($key)
    {
        if (! isset($this->coupons[$key])) {
            throw new Exception('Coupon missing');
        }

        unset($this->coupons[$key]);
    }

    public function totalItems()
    {
        return count($this->items);
    }

    public function totalQuantity()
    {
        $total = 0;

        foreach ($this->getItems() as $item) {
            $total += $item->getQuantity();
        }

        return $total;
    }

    public function getShippingWeight()
    {
        $shippingWeight = 0;

        foreach ($this->getItems() as $item) {
            $shippingWeight += $item->getShippingWeight();
        }

        return $shippingWeight;
    }

    public function getTotal(Pricing $pricing, Shipping\Rate $shippingRate = null, TaxRate $taxRate = null)
    {
        $cartCalculator = new CartCalculator($this);
        return $cartCalculator->getTotal($pricing, $shippingRate, $taxRate);
    }

    public function getOrder(Pricing $pricing, Shipping\Rate $shippingRate = null, TaxRate $taxRate = null)
    {
        $orderItems = [];
        foreach ($this->getItems() as $item) {
            $orderItems[] = $item->getOrderItem($pricing);
        }

        return new Order($orderItems, $this->getTotal($pricing, $shippingRate, $taxRate));
    }

    public function getView()
    {
        return new View\Cart($this);
    }
}
