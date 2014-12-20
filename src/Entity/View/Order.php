<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;

class Order
{
    public $id;
    public $total;
    public $shippingAddress;
    public $billingAddress;
    public $status;
    public $user;
    public $items;
    public $payments;
    public $coupons;

    public function __construct(Entity\Order $order)
    {
        $this->order = $order;

        $this->id              = $order->getId();
        $this->total           = $order->getTotal()->getView()->export();
        $this->shippingAddress = $order->getShippingAddress()->getView();
        $this->billingAddress  = $order->getBillingAddress()->getView();
        $this->status          = $order->getStatus();
    }

    public function export()
    {
        unset($this->order);
        return $this;
    }

    public function withUser()
    {
        $user = $this->order->getUser();
        if (! empty($user)) {
            $this->user = $user->getView()
                ->export();
        }
        return $this;
    }

    public function withItems()
    {
        foreach ($this->order->getItems() as $orderItem) {
            $this->items[] = $orderItem->getView()
                ->withAllData()
                ->export();
        }
        return $this;
    }

    public function withPayments()
    {
        foreach ($this->order->getPayments() as $payment) {
            $this->payments[] = $payment->getView()
                ->export();
        }
        return $this;
    }

    public function withCoupons()
    {
        foreach ($this->order->getCoupons() as $coupon) {
            $this->coupons[] = $coupon->getView()
                ->export();
        }
        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withUser()
            ->withItems()
            ->withPayments()
            ->withCoupons();
    }
}
