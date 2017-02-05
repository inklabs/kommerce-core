<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\RemoveCartCommand;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\CartItem;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class RemoveCartHandlerTest extends ActionTestCase
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
        $cart = $this->dummyData->getCart();
        $this->persistEntityAndFlushClear([
            $cart,
        ]);
        $command = new RemoveCartCommand($cart->getId()->getHex());

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $this->expectException(EntityNotFoundException::class);
        $this->getRepositoryFactory()->getCartRepository()->findOneById(
            $cart->getId()
        );
    }
}
