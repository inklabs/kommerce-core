<?php
namespace inklabs\kommerce\EntityDTO;

class CartDTO
{
    use UuidDTOTrait, TimeDTOTrait;

    /** @var int */
    public $totalItems;

    /** @var int */
    public $totalQuantity;

    /** @var int */
    public $shippingWeight;

    /** @var int */
    public $shippingWeightInPounds;

    /** @var string */
    public $sessionId;

    /** @var ShipmentRateDTO */
    public $shipmentRate;

    /** @var OrderAddressDTO */
    public $shippingAddress;

    /** @var TaxRateDTO */
    public $taxRate;

    /** @var UserDTO */
    public $user;

    /** @var CartTotalDTO */
    public $cartTotal;

    /** @var CartItemDTO[] */
    public $cartItems = [];

    /** @var CouponDTO[] */
    public $coupons = [];
}
