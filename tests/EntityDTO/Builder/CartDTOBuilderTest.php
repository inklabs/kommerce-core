<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\CartItem;
use inklabs\kommerce\Entity\Coupon;
use inklabs\kommerce\Entity\Money;
use inklabs\kommerce\Entity\OrderAddress;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\PromotionType;
use inklabs\kommerce\Entity\ShipmentRate;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Lib\CartCalculator;
use inklabs\kommerce\Lib\Pricing;
use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class CartDTOBuilderTest extends DoctrineTestCase
{
    public function testBuild()
    {
        $cart = $this->dummyData->getCartFull();

        $cartDTO = $cart->getDTOBuilder()
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
