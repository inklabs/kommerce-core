<?php
namespace inklabs\kommerce\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use inklabs\kommerce\Service\Pricing;
use inklabs\kommerce\Entity\Payment as Payment;

class Order
{
    use Accessor\Time;

    protected $id;
    protected $total;
    protected $shippingAddress;
    protected $billingAddress;

    protected $status;
    const STATUS_PENDING    = 0;
    const STATUS_PROCESSING = 1;
    const STATUS_SHIPPED    = 2;
    const STATUS_COMPLETE   = 3;
    const STATUS_CANCELED   = 4;

    protected $user;
    protected $items;
    protected $payments;
    protected $coupons;

    public function __construct(
        Cart $cart,
        Pricing $pricing,
        Shipping\Rate $shippingRate = null,
        TaxRate $taxRate = null
    ) {
        $this->setCreated();
        $this->items = new ArrayCollection();
        $this->payments = new ArrayCollection();
        $this->coupons = new ArrayCollection();

        $this->setStatus(new OrderStatus\Pending);
        $this->setTotal($cart->getTotal($pricing, $shippingRate, $taxRate));
        $this->setItems($cart->getItems(), $pricing);
    }

    private function setItems($cartItems, Pricing $pricing)
    {
        foreach ($cartItems as $cartItem) {
            $this->addItem($cartItem, $pricing);
        }
    }

    private function addItem(CartItem $cartItem, Pricing $pricing)
    {
        $orderItem = new OrderItem($cartItem, $pricing);
        $orderItem->setOrder($this);
        $this->items[] = $orderItem;

        end($this->items);
        $id = key($this->items);

        return $id;
    }

    public function setStatus(OrderStatus\Status $status)
    {
        $this->status = $status->getCode();
    }

    public function getId()
    {
        return $this->id;
    }

    private function setTotal(CartTotal $total)
    {
        $this->total = $total;
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

    public function addPayment(Payment\Payment $payment)
    {
        $payment->addOrder($this);
        $this->payments[] = $payment;
    }

    /**
     * @return Payment\Payment[]
     */
    public function getPayments()
    {
        return $this->payments;
    }

    public function addCoupon(Coupon $coupon)
    {
        $this->coupons[] = $coupon;
    }

    public function getCoupons()
    {
        return $this->coupons;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}
