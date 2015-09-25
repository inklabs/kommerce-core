<?php
namespace inklabs\kommerce\EntityDTO;

class CartDTO
{
    public $id;
    public $totalItems;
    public $totalQuantity;
    public $shippingWeight;
    public $shippingWeightInPounds;
    public $sessionId;
    public $created;
    public $updated;

    /** @var ShippingRateDTO */
    public $shippingRate;

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
