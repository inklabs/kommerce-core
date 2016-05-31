<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\EntityDTO\OrderDTO;

class OrderDTOBuilder
{
    /** @var Order */
    protected $order;

    /** @var OrderDTO */
    protected $orderDTO;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(Order $order, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->order = $order;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->orderDTO = new OrderDTO;
        $this->orderDTO->id              = $this->order->getId();
        $this->orderDTO->referenceNumber = $this->order->getReferenceNumber();
        $this->orderDTO->externalId      = $this->order->getExternalId();
        $this->orderDTO->totalItems      = $this->order->totalItems();
        $this->orderDTO->totalQuantity   = $this->order->totalQuantity();
        $this->orderDTO->created         = $this->order->getCreated();
        $this->orderDTO->updated         = $this->order->getUpdated();

        $this->orderDTO->status = $this->dtoBuilderFactory
            ->getOrderStatusTypeDTOBuilder($this->order->getStatus())
            ->build();

        if ($this->order->getShippingAddress() !== null) {
            $this->orderDTO->shippingAddress = $this->dtoBuilderFactory
                ->getOrderAddressDTOBuilder($this->order->getShippingAddress())
                ->build();
        }

        if ($this->order->getBillingAddress() !== null) {
            $this->orderDTO->billingAddress = $this->dtoBuilderFactory
                ->getOrderAddressDTOBuilder($this->order->getBillingAddress())
                ->build();
        }

        if ($this->order->getTotal() !== null) {
            $this->orderDTO->total = $this->dtoBuilderFactory
                ->getCartTotalDTOBuilder($this->order->getTotal())
                ->withAllData()
                ->build();
        }

        if ($this->order->getShipmentRate() !== null) {
            $this->orderDTO->shipmentRate = $this->dtoBuilderFactory
                ->getShipmentRateDTOBuilder($this->order->getShipmentRate())
                ->build();
        }

        if ($this->order->getTaxRate() !== null) {
            $this->orderDTO->taxRate = $this->dtoBuilderFactory
                ->getTaxRateDTOBuilder($this->order->getTaxRate())
                ->build();
        }

        foreach ($this->order->getShipments() as $shipment) {
            $this->orderDTO->shipments[] = $this->dtoBuilderFactory
                ->getShipmentDTOBuilder($shipment)
                ->build();
        }
    }

    public function withUser()
    {
        $user = $this->order->getUser();
        if (! empty($user)) {
            $this->orderDTO->user = $this->dtoBuilderFactory
                ->getUserDTOBuilder($user)
                ->build();
        }
        return $this;
    }

    public function withItems()
    {
        foreach ($this->order->getOrderItems() as $orderItem) {
            $this->orderDTO->orderItems[] = $this->dtoBuilderFactory
                ->getOrderItemDTOBuilder($orderItem)
                ->withAllData()
                ->build();
        }
        return $this;
    }

    public function withPayments()
    {
        foreach ($this->order->getPayments() as $payment) {
            $this->orderDTO->payments[] = $this->dtoBuilderFactory
                ->getPaymentDTOBuilder($payment)
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
