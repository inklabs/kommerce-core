<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\DeleteCartItemCommand;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\CartItem;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class DeleteCartItemHandlerTest extends ActionTestCase
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
        $product = $this->dummyData->getProduct();
        $cartItem = $this->dummyData->getCartItem($product);
        $cart = $this->dummyData->getCart([$cartItem]);
        $this->persistEntityAndFlushClear([
            $cart,
            $product,
        ]);
        $command = new DeleteCartItemCommand($cartItem->getId()->getHex());

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $cart = $this->getRepositoryFactory()->getCartRepository()->findOneById(
            $cart->getId()
        );
        $this->assertEmpty($cart->getCartItems());
    }
}
