<?php
namespace inklabs\kommerce\EntityDTO;

class OrderDTO
{
    use IdDTOTrait, TimeDTOTrait;

    public $externalId;
    public $referenceNumber;
    public $shippingAddress;
    public $billingAddress;
    public $status;
    public $statusText;
    public $totalItems;
    public $totalQuantity;

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

    /** @var ShippingRateDTO */
    public $shippingRate;

    /** @var TaxRateDTO */
    public $taxRate;
}
