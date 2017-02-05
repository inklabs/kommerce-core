<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\GetCartQuery;
use inklabs\kommerce\Action\Cart\Query\GetCartRequest;
use inklabs\kommerce\Action\Cart\Query\GetCartResponse;
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
        $request = new GetCartRequest($cart->getId()->getHex());
        $response = new GetCartResponse($this->getCartCalculator());
        $query = new GetCartQuery($request, $response);

        $this->dispatchQuery($query);
        $this->assertEquals($cart->getId(), $response->getCartDTO()->id);

        $this->dispatchQuery($query);
        $this->assertEquals($cart->getId(), $response->getCartDTOWithAllData()->id);
    }
}
