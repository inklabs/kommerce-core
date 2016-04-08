<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class CartTotalDTOBuilderTest extends DoctrineTestCase
{
    public function testBuild()
    {
        $cartTotal = $this->dummyData->getCartTotal();
        $cartTotal->coupons = [$this->dummyData->getCoupon()];
        $cartTotal->cartPriceRules = [$this->dummyData->getCartPriceRule()];

        $cartTotalDTO = $cartTotal->getDTOBuilder()
            ->withAllData()
            ->build();

        $this->assertTrue($cartTotalDTO instanceof CartTotalDTO);
        $this->assertTrue($cartTotalDTO->coupons[0] instanceof CouponDTO);
        $this->assertTrue($cartTotalDTO->cartPriceRules[0] instanceof CartPriceruleDTO);
    }
}
