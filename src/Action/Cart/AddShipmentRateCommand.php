<?php
namespace inklabs\kommerce\Action\Cart;

use inklabs\kommerce\EntityDTO\OrderAddressDTO;
use inklabs\kommerce\Lib\Command\CommandInterface;

final class AddShipmentRateCommand implements CommandInterface
{
    /** @var int */
    private $cartId;

    /** @var string */
    private $shipmentRateExternalId;

    /** @var OrderAddressDTO */
    private $billingAddressDTO;

    /**
     * @param int $cartId
     * @param string $shipmentRateExternalId
     * @param OrderAddressDTO $billingAddressDTO
     */
    public function __construct(
        $cartId,
        $shipmentRateExternalId,
        OrderAddressDTO $billingAddressDTO
    ) {
        $this->cartId = (int) $cartId;
        $this->shipmentRateExternalId = (string) $shipmentRateExternalId;
        $this->billingAddressDTO = $billingAddressDTO;
    }

    public function getCartId()
    {
        return $this->cartId;
    }

    public function getShipmentRateExternalId()
    {
        return $this->shipmentRateExternalId;
    }

    public function getBillingAddressDTO()
    {
        return $this->billingAddressDTO;
    }
}
