<?php
namespace inklabs\kommerce\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Order
{
    use Accessor\Time;

    protected $status = 'pending'; // 'pending','processing','shipped','complete','canceled'
    protected $total;
    protected $shippingAddress;
    protected $billingAddress;
    protected $items;
    protected $payments;

    public function __construct(Cart $cart, \inklabs\kommerce\Service\Pricing $pricing)
    {
        $this->items = new ArrayCollection();
        $this->payments = new ArrayCollection();
        $this->total = $cart->getTotal($pricing);
        $this->setItems($cart->getItems(), $pricing);
    }

    private function setItems($cartItems, \inklabs\kommerce\Service\Pricing $pricing)
    {
        foreach ($cartItems as $cartItem) {
            $this->addItem($cartItem, $pricing);
        }
    }

    private function addItem(CartItem $cartItem, \inklabs\kommerce\Service\Pricing $pricing)
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
        return $this->total;
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

    public function addPayment(Payment $payment)
    {
        $this->payments[] = $payment;
    }

    public function getPayments()
    {
        return $this->payments;
    }
}
