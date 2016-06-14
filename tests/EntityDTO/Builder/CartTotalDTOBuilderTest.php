<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\EntityDTO\CartPriceRuleDTO;
use inklabs\kommerce\EntityDTO\CartTotalDTO;
use inklabs\kommerce\EntityDTO\CouponDTO;
use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

class CartTotalDTOBuilderTest extends EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $cartTotal = $this->dummyData->getCartTotal();
        $cartTotal->coupons = [$this->dummyData->getCoupon()];
        $cartTotal->cartPriceRules = [$this->dummyData->getCartPriceRule()];

        $cartTotalDTO = $this->getDTOBuilderFactory()
            ->getCartTotalDTOBuilder($cartTotal)
            ->withAllData()
            ->build();

        $this->assertTrue($cartTotalDTO instanceof CartTotalDTO);
        $this->assertTrue($cartTotalDTO->coupons[0] instanceof CouponDTO);
        $this->assertTrue($cartTotalDTO->cartPriceRules[0] instanceof CartPriceruleDTO);
    }
}
