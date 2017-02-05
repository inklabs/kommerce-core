<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\GetCartByUserIdQuery;
use inklabs\kommerce\Action\Cart\Query\GetCartByUserIdRequest;
use inklabs\kommerce\Action\Cart\Query\GetCartByUserIdResponse;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\CartItem;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class GetCartByUserIdHandlerTest extends ActionTestCase
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
        $user = $this->dummyData->getUser();
        $cart = $this->dummyData->getCart();
        $cart->setUser($user);
        $this->persistEntityAndFlushClear([
            $cart,
            $user,
        ]);
        $request = new GetCartByUserIdRequest($user->getId()->getHex());
        $response = new GetCartByUserIdResponse($this->getCartCalculator());
        $query = new GetCartByUserIdQuery($request, $response);

        $this->dispatchQuery($query);

        $this->assertEquals($cart->getId(), $response->getCartDTO()->id);
    }
}
