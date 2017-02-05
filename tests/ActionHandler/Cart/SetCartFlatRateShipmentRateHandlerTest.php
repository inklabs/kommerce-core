<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\SetCartFlatRateShipmentRateCommand;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\CartItem;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\EntityDTO\MoneyDTO;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class SetCartFlatRateShipmentRateHandlerTest extends ActionTestCase
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
        $moneyDTO = new MoneyDTO;
        $amount = self::ONE_DOLLAR;
        $currency = self::CURRENCY;
        $moneyDTO->amount = $amount;
        $moneyDTO->currency = $currency;
        $command = new SetCartFlatRateShipmentRateCommand(
            $cart->getId()->getHex(),
            $moneyDTO
        );

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $cart = $this->getRepositoryFactory()->getCartRepository()->findOneById(
            $cart->getId()
        );
        $shipmentRate = $cart->getShipmentRate()->getRate();
        $this->assertSame($amount, $shipmentRate->getAmount());
        $this->assertSame($currency, $shipmentRate->getCurrency());
    }
}
