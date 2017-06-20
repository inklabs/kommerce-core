<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\SetCartTaxRateByZip5AndStateCommand;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\CartItem;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class SetCartTaxRateByZip5AndStateHandlerTest extends ActionTestCase
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
        $taxRate = $this->dummyData->getTaxRate();
        $this->persistEntityAndFlushClear([
            $cart,
            $taxRate,
        ]);
        $command = new SetCartTaxRateByZip5AndStateCommand(
            $cart->getId()->getHex(),
            $taxRate->getZip5(),
            $taxRate->getState()
        );

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $cart = $this->getRepositoryFactory()->getCartRepository()->findOneById(
            $cart->getId()
        );
        $this->assertEntitiesEqual($taxRate, $cart->getTaxRate());
    }
}
