<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\AbstractPromotion;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\CartItem;
use inklabs\kommerce\Entity\Coupon;
use inklabs\kommerce\Entity\Money;
use inklabs\kommerce\Entity\OrderAddress;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\ShipmentRate;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Lib\CartCalculator;
use inklabs\kommerce\Lib\Pricing;

class CartDTOBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $coupon = new Coupon;
        $coupon->setId(1);
        $coupon->setType(AbstractPromotion::TYPE_PERCENT);

        $cartItem= new CartItem;
        $cartItem->setProduct(new Product);
        $cartItem->setQuantity(1);

        $cart = new Cart;
        $cart->addCartItem($cartItem);
        $cart->addCoupon($coupon);
        $cart->setShipmentRate(new ShipmentRate(new Money(295, 'USD')));
        $cart->setShippingAddress(new OrderAddress);
        $cart->setTaxRate(new TaxRate);
        $cart->setuser(new User);

        $cartDTO = $cart->getDTOBuilder()
            ->withAllData(new CartCalculator(new Pricing))
            ->build();

        $this->assertTrue($cartDTO instanceof CartDTO);
        $this->assertTrue($cartDTO->cartTotal instanceof CartTotalDTO);
        $this->assertTrue($cartDTO->cartItems[0] instanceof CartItemDTO);
        $this->assertTrue($cartDTO->coupons[0] instanceof CouponDTO);
        $this->assertTrue($cartDTO->shipmentRate instanceof ShipmentRateDTO);
        $this->assertTrue($cartDTO->shippingAddress instanceof OrderAddressDTO);
        $this->assertTrue($cartDTO->taxRate instanceof TaxRateDTO);
        $this->assertTrue($cartDTO->user instanceof UserDTO);
    }
}
