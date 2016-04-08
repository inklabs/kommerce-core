<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\CartPriceRule;
use inklabs\kommerce\Entity\CartTotal;
use inklabs\kommerce\Entity\Coupon;

class CartTotalDTOBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $cartTotal = new CartTotal;
        $cartTotal->coupons = [new Coupon];
        $cartTotal->cartPriceRules = [new CartPriceRule];

        $cartTotalDTO = $cartTotal->getDTOBuilder()
            ->withAllData()
            ->build();

        $this->assertTrue($cartTotalDTO instanceof CartTotalDTO);
        $this->assertTrue($cartTotalDTO->coupons[0] instanceof CouponDTO);
        $this->assertTrue($cartTotalDTO->cartPriceRules[0] instanceof CartPriceruleDTO);
    }
}
