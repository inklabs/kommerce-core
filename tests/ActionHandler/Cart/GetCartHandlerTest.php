<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\GetCartQuery;
use inklabs\kommerce\ActionResponse\Cart\GetCartResponse;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\CartItem;
use inklabs\kommerce\Entity\Coupon;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class GetCartHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Cart::class,
        CartItem::class,
        Coupon::class,
        Product::class,
        User::class,
        TaxRate::class,
    ];

    public function testHandle()
    {
        $cart = $this->dummyData->getCart();
        $this->persistEntityAndFlushClear([
            $cart,
        ]);
        $query = new GetCartQuery($cart->getId()->getHex());

        /** @var GetCartResponse $response */
        $response = $this->dispatchQuery($query);
        $this->assertEquals($cart->getId(), $response->getCartDTO()->id);

        $response = $this->dispatchQuery($query);
        $this->assertEquals($cart->getId(), $response->getCartDTOWithAllData()->id);
    }
}
