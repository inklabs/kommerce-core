<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Lib;

class Order implements ViewInterface
{
    public $id;
    public $externalId;
    public $referenceNumber;
    public $encodedId;
    public $shippingAddress;
    public $billingAddress;
    public $status;
    public $statusText;
    public $totalItems;
    public $totalQuantity;
    public $created;
    public $updated;

    /** @var CartTotal */
    public $total;

    /** @var User */
    public $user;

    /** @var OrderItem[] */
    public $orderItems = [];

    /** @var AbstractPayment[] */
    public $payments = [];

    /** @var Coupon[] */
    public $coupons = [];

    public function __construct(Entity\Order $order)
    {
        $this->order = $order;

        $this->id              = $order->getId();
        $this->encodedId       = Lib\BaseConvert::encode($order->getId());
        $this->referenceNumber = $order->getReferenceNumber();
        $this->externalId      = $order->getExternalId();
        $this->status          = $order->getStatus();
        $this->statusText      = $order->getStatusText();
        $this->totalItems      = $order->totalItems();
        $this->totalQuantity   = $order->totalQuantity();
        $this->created         = $order->getCreated();
        $this->updated         = $order->getUpdated();

        if ($order->getShippingAddress() !== null) {
            $this->shippingAddress = $order->getShippingAddress()->getView();
        }

        if ($order->getBillingAddress() !== null) {
            $this->billingAddress = $order->getBillingAddress()->getView();
        }

        if ($order->getTotal() !== null) {
            $this->total = $order->getTotal()->getView()
                ->withAllData()
                ->export();
        }
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
        foreach ($this->order->getOrderItems() as $orderItem) {
            $this->orderItems[] = $orderItem->getView()
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
