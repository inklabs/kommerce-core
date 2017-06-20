<?php
namespace inklabs\kommerce\Action\Cart;

use inklabs\kommerce\EntityDTO\OrderAddressDTO;
use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class SetExternalShipmentRateCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $cartId;

    /** @var string */
    private $shipmentRateExternalId;

    /** @var OrderAddressDTO */
    private $shippingAddressDTO;

    public function __construct(
        string $cartId,
        string $shipmentRateExternalId,
        OrderAddressDTO $shippingAddressDTO
    ) {
        $this->cartId = Uuid::fromString($cartId);
        $this->shipmentRateExternalId = $shipmentRateExternalId;
        $this->shippingAddressDTO = $shippingAddressDTO;
    }

    public function getCartId(): UuidInterface
    {
        return $this->cartId;
    }

    public function getShipmentRateExternalId(): string
    {
        return $this->shipmentRateExternalId;
    }

    public function getShippingAddressDTO(): OrderAddressDTO
    {
        return $this->shippingAddressDTO;
    }
}
