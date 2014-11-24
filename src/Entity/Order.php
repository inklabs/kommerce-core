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

    // OrderAddress
    protected $shippingAddress;
    protected $shippingFirstName;
    protected $shippingLastName;
    protected $shippingCompany;
    protected $shippingAddress1;
    protected $shippingAddress2;
    protected $shippingCity;
    protected $shippingState;
    protected $shippingZip5;
    protected $shippingZip4;
    protected $shippingPhone;
    protected $shippingEmail;

    // OrderAddress
    protected $billingAddress;
    protected $billingFirstName;
    protected $billingLastName;
    protected $billingCompany;
    protected $billingAddress1;
    protected $billingAddress2;
    protected $billingCity;
    protected $billingState;
    protected $billingZip5;
    protected $billingZip4;
    protected $billingPhone;
    protected $billingEmail;

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

        $this->shippingFirstName = $shippingAddress->firstName;
        $this->shippingLastName = $shippingAddress->lastName;
        $this->shippingCompany = $shippingAddress->company;
        $this->shippingAddress1 = $shippingAddress->address1;
        $this->shippingAddress2 = $shippingAddress->address2;
        $this->shippingCity = $shippingAddress->city;
        $this->shippingState = $shippingAddress->state;
        $this->shippingZip5 = $shippingAddress->zip5;
        $this->shippingZip4 = $shippingAddress->zip4;
        $this->shippingPhone = $shippingAddress->phone;
        $this->shippingEmail = $shippingAddress->email;
    }

    public function setBillingAddress(OrderAddress $billingAddress)
    {
        $this->billingAddress = $billingAddress;

        $this->billingFirstName = $billingAddress->firstName;
        $this->billingLastName = $billingAddress->lastName;
        $this->billingCompany = $billingAddress->company;
        $this->billingAddress1 = $billingAddress->address1;
        $this->billingAddress2 = $billingAddress->address2;
        $this->billingCity = $billingAddress->city;
        $this->billingState = $billingAddress->state;
        $this->billingZip5 = $billingAddress->zip5;
        $this->billingZip4 = $billingAddress->zip4;
        $this->billingPhone = $billingAddress->phone;
        $this->billingEmail = $billingAddress->email;
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
