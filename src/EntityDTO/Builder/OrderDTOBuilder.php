<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\EntityDTO\OrderDTO;
use inklabs\kommerce\Lib\BaseConvert;

class OrderDTOBuilder
{
    /** @var Order */
    protected $order;

    /** @var OrderDTO */
    protected $orderDTO;

    public function __construct(Order $order)
    {
        $this->order = $order;

        $this->orderDTO = new OrderDTO;
        $this->orderDTO->id              = $this->order->getId();
        $this->orderDTO->encodedId       = BaseConvert::encode($this->order->getId());
        $this->orderDTO->referenceNumber = $this->order->getReferenceNumber();
        $this->orderDTO->externalId      = $this->order->getExternalId();
        $this->orderDTO->status          = $this->order->getStatus();
        $this->orderDTO->statusText      = $this->order->getStatusText();
        $this->orderDTO->totalItems      = $this->order->totalItems();
        $this->orderDTO->totalQuantity   = $this->order->totalQuantity();
        $this->orderDTO->created         = $this->order->getCreated();
        $this->orderDTO->updated         = $this->order->getUpdated();

        if ($this->order->getShippingAddress() !== null) {
            $this->orderDTO->shippingAddress = $this->order->getShippingAddress()->getDTOBuilder()
                ->build();
        }

        if ($this->order->getBillingAddress() !== null) {
            $this->orderDTO->billingAddress = $this->order->getBillingAddress()->getDTOBuilder()
                ->build();
        }

        if ($this->order->getTotal() !== null) {
            $this->orderDTO->total = $this->order->getTotal()->getDTOBuilder()
                ->withAllData()
                ->build();
        }

        if ($this->order->getShippingRate() !== null) {
            $this->orderDTO->shippingRate = $this->order->getShippingRate()->getDTOBuilder()
                ->build();
        }

        if ($this->order->getTaxRate() !== null) {
            $this->orderDTO->taxRate = $this->order->getTaxRate()->getDTOBuilder()
                ->build();
        }

        foreach ($this->order->getShipments() as $shipment) {
            $this->orderDTO->shipments[] = $shipment->getDTOBuilder()
                ->build();
        }
    }

    public function withUser()
    {
        $user = $this->order->getUser();
        if (! empty($user)) {
            $this->orderDTO->user = $user->getDTOBuilder()
                ->build();
        }
        return $this;
    }

    public function withItems()
    {
        foreach ($this->order->getOrderItems() as $orderItem) {
            $this->orderDTO->orderItems[] = $orderItem->getDTOBuilder()
                ->withAllData()
                ->build();
        }
        return $this;
    }

    public function withPayments()
    {
        foreach ($this->order->getPayments() as $payment) {
            $this->orderDTO->payments[] = $payment->getDTOBuilder()
                ->build();
        }
        return $this;
    }

    public function withCoupons()
    {
        foreach ($this->order->getCoupons() as $coupon) {
            $this->orderDTO->coupons[] = $coupon->getDTOBuilder()
                ->build();
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

    public function build()
    {
        return $this->orderDTO;
    }
}
