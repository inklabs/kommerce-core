<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

class CartDTOBuilderTest extends EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $cart = $this->dummyData->getCartFull();

        $cartDTO = $this->getDTOBuilderFactory()
            ->getCartDTOBuilder($cart)
            ->withAllData($this->getCartCalculator())
            ->build();

        $this->assertTrue($cartDTO instanceof CartDTO);
        $this->assertTrue($cartDTO->user instanceof UserDTO);
        $this->assertTrue($cartDTO->shippingAddress instanceof OrderAddressDTO);
        $this->assertTrue($cartDTO->shipmentRate instanceof ShipmentRateDTO);
        $this->assertTrue($cartDTO->taxRate instanceof TaxRateDTO);
        $this->assertTrue($cartDTO->cartTotal instanceof CartTotalDTO);
        $this->assertTrue($cartDTO->cartItems[0] instanceof CartItemDTO);
        $this->assertTrue($cartDTO->coupons[0] instanceof CouponDTO);
    }
}
