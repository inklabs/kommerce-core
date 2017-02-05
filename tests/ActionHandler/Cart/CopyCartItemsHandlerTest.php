<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\CopyCartItemsCommand;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\CartItem;
use inklabs\kommerce\Entity\CartItemOptionProduct;
use inklabs\kommerce\Entity\CartItemOptionValue;
use inklabs\kommerce\Entity\CartItemTextOptionValue;
use inklabs\kommerce\Entity\OptionProduct;
use inklabs\kommerce\Entity\OptionValue;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\TextOption;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CopyCartItemsHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Cart::class,
        CartItem::class,
        CartItemOptionProduct::class,
        CartItemOptionValue::class,
        CartItemTextOptionValue::class,
        TextOption::class,
        OptionProduct::class,
        OptionValue::class,
        Product::class,
        User::class,
        TaxRate::class,
    ];

    public function testHandle()
    {
        $product = $this->dummyData->getProduct();
        $cartItem = $this->dummyData->getCartItem($product);
        $cart1 = $this->dummyData->getCart([$cartItem]);
        $cart2 = $this->dummyData->getCart();
        $this->persistEntityAndFlushClear([
            $cart1,
            $cart2,
            $product,
        ]);
        $command = new CopyCartItemsCommand(
            $cart1->getId()->getHex(),
            $cart2->getId()->getHex()
        );

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $cart = $this->getRepositoryFactory()->getCartRepository()->findOneById(
            $cart2->getId()
        );
        $this->assertEntitiesEqual($product, $cart->getCartItems()[0]->getProduct());
    }
}
