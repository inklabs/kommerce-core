<?php
namespace inklabs\kommerce\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use inklabs\kommerce\Service\Pricing;
use inklabs\kommerce\Entity\Payment as Payment;

class Order
{
    use Accessor\Time;

    protected $id;

    /* @var CartTotal */
    protected $total;

    /* @var OrderAddress */
    protected $shippingAddress;

    /* @var OrderAddress */
    protected $billingAddress;

    protected $status;
    const STATUS_PENDING    = 0;
    const STATUS_PROCESSING = 1;
    const STATUS_SHIPPED    = 2;
    const STATUS_COMPLETE   = 3;
    const STATUS_CANCELED   = 4;

    /* @var User */
    protected $user;

    /* @var OrderItem[] */
    protected $items;

    /* @var Payment\Payment[] */
    protected $payments;

    /* @var Coupon[] */
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

        $this->setStatus(self::STATUS_PENDING);
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

    public function setId($id)
    {
        $this->id = (int) $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setStatus($status)
    {
        $this->status = (int) $status;
    }

    public function getStatus()
    {
        return $this->status;
    }

    private function setTotal(CartTotal $total)
    {
        $this->total = $total;
    }

    /**
     * @return CartTotal
     */
    public function getTotal()
    {
        return $this->total;
    }

    public function setShippingAddress(OrderAddress $shippingAddress)
    {
        $this->shippingAddress = $shippingAddress;
    }

    /**
     * @return OrderAddress
     */
    public function getShippingAddress()
    {
        return $this->shippingAddress;
    }

    public function setBillingAddress(OrderAddress $billingAddress)
    {
        $this->billingAddress = $billingAddress;
    }

    /**
     * @return OrderAddress
     */
    public function getBillingAddress()
    {
        return $this->billingAddress;
    }

    /**
     * @return OrderItem[]
     */
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

    /**
     * @return Coupon[]
     */
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

    public function getView()
    {
        return new View\Order($this);
    }
}
