<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\GetCartBySessionIdQuery;
use inklabs\kommerce\ActionResponse\Cart\GetCartBySessionIdResponse;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\CartItem;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class GetCartBySessionIdHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Cart::class,
        CartItem::class,
        Product::class,
        User::class,
        TaxRate::class,
    ];

    public function testHandle()
    {
        $sessionId = self::SESSION_ID;
        $cart = $this->dummyData->getCart();
        $cart->setSessionId($sessionId);
        $this->persistEntityAndFlushClear([
            $cart,
        ]);
        $query = new GetCartBySessionIdQuery($sessionId);

        /** @var GetCartBySessionIdResponse $response */
        $response = $this->dispatchQuery($query);

        $this->assertEquals($cart->getId(), $response->getCartDTO()->id);
    }
}
