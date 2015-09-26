<?php
namespace inklabs\kommerce\EntityDTO;

class OrderDTO
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
}
