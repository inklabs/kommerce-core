<?php
namespace inklabs\kommerce\EntityDTO;

class OrderDTO
{
    use IdDTOTrait, TimeDTOTrait;

    /** @var string */
    public $externalId;

    /** @var string */
    public $referenceNumber;

    /** @var OrderAddressDTO */
    public $shippingAddress;

    /** @var OrderAddressDTO */
    public $billingAddress;

    /** @var OrderStatusTypeDTO */
    public $status;

    /** @var int */
    public $totalItems;

    /** @var int */
    public $totalQuantity;

    /** @var string */
    public $discountNames;

    /** @var CartTotalDTO */
    public $total;

    /** @var UserDTO */
    public $user;

    /** @var OrderItemDTO[] */
    public $orderItems = [];

    /** @var CreditPaymentDTO[] | CashPaymentDTO[] | CheckPaymentDTO[] */
    public $payments = [];

    /** @var CouponDTO[] */
    public $coupons = [];

    /** @var ShipmentRateDTO | null */
    public $shipmentRate;

    /** @var TaxRateDTO */
    public $taxRate;

    /** @var ShipmentDTO[] */
    public $shipments = [];
}
