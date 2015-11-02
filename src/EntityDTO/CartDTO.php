<?php
namespace inklabs\kommerce\EntityDTO;

class CartDTO
{
    use IdDTOTrait, TimeDTOTrait;

    public $totalItems;
    public $totalQuantity;
    public $shippingWeight;
    public $shippingWeightInPounds;
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
