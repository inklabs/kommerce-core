<?php
namespace inklabs\kommerce\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use inklabs\kommerce\Service\Pricing;
use inklabs\kommerce\Entity\Payment as Payment;

class Order
{
    use Accessor\Time;

    protected $id;
    protected $status = 'pending'; // 'pending','processing','shipped','complete','canceled'

    protected $cartTotal;
    protected $origSubtotal;
    protected $subtotal;
    protected $taxSubtotal;
    protected $discount;
    protected $shipping;
    protected $shippingDiscount;
    protected $tax;
    protected $total;
    protected $savings;
    protected $coupons;
    protected $cartPriceRules;
    protected $taxRate;

    protected $shippingAddress;
    protected $billingAddress;

    protected $items;
    protected $payments;

    public function __construct(
        Cart $cart,
        Pricing $pricing,
        Shipping\Rate $shippingRate = null,
        TaxRate $taxRate = null
    ) {
        $this->setCreated();
        $this->items = new ArrayCollection();
        $this->cash_payments = new ArrayCollection();
        $this->credit_payments = new ArrayCollection();
        $this->setCartTotal($cart->getTotal($pricing, $shippingRate, $taxRate));
        $this->setItems($cart->getItems(), $pricing);
    }

    private function setCartTotal(CartTotal $cartTotal)
    {
        $this->cartTotal = $cartTotal;

        $this->origSubtotal = $cartTotal->origSubtotal;
        $this->subtotal = $cartTotal->subtotal;
        $this->taxSubtotal = $cartTotal->taxSubtotal;
        $this->discount = $cartTotal->discount;
        $this->shipping = $cartTotal->shipping;
        $this->shippingDiscount = $cartTotal->shippingDiscount;
        $this->tax = $cartTotal->tax;
        $this->total = $cartTotal->total;
        $this->savings = $cartTotal->savings;
        $this->coupons = $cartTotal->coupons;
        $this->cartPriceRules = $cartTotal->cartPriceRules;
        $this->taxRate = $cartTotal->taxRate;
    }

    private function setItems($cartItems, Pricing $pricing)
    {
        foreach ($cartItems as $cartItem) {
            $this->addItem($cartItem, $pricing);
        }
    }

    private function addItem(CartItem $cartItem, Pricing $pricing)
    {
        $this->items[] = new OrderItem($cartItem, $pricing);

        end($this->items);
        $id = key($this->items);

        return $id;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getTotal()
    {
        return $this->cartTotal;
    }

    public function setShippingAddress(OrderAddress $shippingAddress)
    {
        $this->shippingAddress = $shippingAddress;
    }

    public function setBillingAddress(OrderAddress $billingAddress)
    {
        $this->billingAddress = $billingAddress;
    }

    public function getItems()
    {
        return $this->items;
    }

    public function addPayment(Payment\Payment $payment)
    {
        $this->payments[] = $payment;
    }

    public function getPayments()
    {
        return $this->payments;
    }
}
