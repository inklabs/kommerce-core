<?php
namespace inklabs\kommerce\EntityDTO;

class OrderDTO
{
    use IdDTOTrait, TimeDTOTrait;

    public $externalId;
    public $referenceNumber;

    /** @var OrderAddressDTO */
    public $shippingAddress;

    /** @var OrderAddressDTO */
    public $billingAddress;

    public $status;
    public $statusText;
    public $totalItems;
    public $totalQuantity;

    /** @var string[] */
    public $statusMapping;

    /** @var CartTotalDTO */
    public $total;

    /** @var UserDTO */
    public $user;

    /** @var OrderItemDTO[] */
    public $orderItems = [];

    /** @var CreditPaymentDTO[]|CashPaymentDTO[] */
    public $payments = [];

    /** @var CouponDTO[] */
    public $coupons = [];

    /** @var ShipmentRateDTO */
    public $shipmentRate;

    /** @var TaxRateDTO */
    public $taxRate;

    /** @var ShipmentDTO[] */
    public $shipments = [];
}
