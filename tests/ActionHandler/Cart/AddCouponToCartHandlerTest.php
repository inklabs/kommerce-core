<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\AddCouponToCartCommand;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\CartItem;
use inklabs\kommerce\Entity\Coupon;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class AddCouponToCartHandlerTest extends ActionTestCase
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
        $cart = $this->dummyData->getCart();
        $coupon = $this->dummyData->getCoupon();
        $this->persistEntityAndFlushClear([
            $cart,
            $coupon,
        ]);
        $command = new AddCouponToCartCommand(
            $cart->getId()->getHex(),
            $coupon->getCode()
        );

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $cart = $this->getRepositoryFactory()->getCartRepository()->findOneById(
            $cart->getId()
        );
        $this->assertEntityInList($coupon, $cart->getCoupons());
    }
}
