<?php
namespace inklabs\kommerce\ActionHandler\Cart;

use inklabs\kommerce\Action\Cart\SetExternalShipmentRateCommand;
use inklabs\kommerce\Entity\Cart;
use inklabs\kommerce\Entity\CartItem;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class SetExternalShipmentRateHandlerTest extends ActionTestCase
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
        $shipmentRateExternalId = self::SHIPMENT_RATE_EXTERNAL_ID;
        $orderAddressDTO = $this->getDTOBuilderFactory()
            ->getOrderAddressDTOBuilder($this->dummyData->getOrderAddress())
            ->build();
        $command = new SetExternalShipmentRateCommand(
            $cart->getId()->getHex(),
            $shipmentRateExternalId,
            $orderAddressDTO
        );

        $this->dispatchCommand($command);

        $this->entityManager->clear();
        $cart = $this->getRepositoryFactory()->getCartRepository()->findOneById(
            $cart->getId()
        );
        $this->assertSame($shipmentRateExternalId, $cart->getShipmentRate()->getShipmentExternalId());
        $this->assertSame($orderAddressDTO->address1, $cart->getShippingAddress()->getAddress1());
    }
}
