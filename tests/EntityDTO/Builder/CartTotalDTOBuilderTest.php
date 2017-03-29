<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

class CartTotalDTOBuilderTest extends EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $cartTotal = $this->dummyData->getCartTotal();
        $cartTotal->coupons = [$this->dummyData->getCoupon()];
        $cartTotal->addCartPriceRule($this->dummyData->getCartPriceRule());

        $cartTotalDTO = $this->getDTOBuilderFactory()
            ->getCartTotalDTOBuilder($cartTotal)
            ->withAllData()
            ->build();

        $this->assertTrue($cartTotalDTO instanceof CartTotalDTO);
        $this->assertTrue($cartTotalDTO->coupons[0] instanceof CouponDTO);
        $this->assertTrue($cartTotalDTO->cartPriceRules[0] instanceof CartPriceruleDTO);
    }
}
