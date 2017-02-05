<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\RemoveCouponFromCartCommand;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\CartItem;
use inklabs\kommerce\Entity\Coupon;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class RemoveCouponFromCartHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Cart::class,
        CartItem::class,
        Product::class,
        Coupon::class,
        User::class,
        TaxRate::class,
    ];

    public function testHandle()
    {
        $coupon = $this->dummyData->getCoupon();
        $cart = $this->dummyData->getCart();
        $cart->addCoupon($coupon);
        $this->persistEntityAndFlushClear([
            $cart,
            $coupon,
        ]);
        $command = new RemoveCouponFromCartCommand(
            $cart->getId()->getHex(),
            $coupon->getId()->getHex()
        );

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $cart = $this->getRepositoryFactory()->getCartRepository()->findOneById(
            $cart->getId()
        );
        $this->assertEmpty($cart->getCoupons());
    }
}
