<?php
namespace inklabs\kommerce\Action\Cart;

use inklabs\kommerce\EntityDTO\MoneyDTO;
use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class SetCartFlatRateShipmentRateCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $cartId;

    /** @var MoneyDTO */
    private $moneyDTO;

    public function __construct(string $cartId, MoneyDTO $moneyDTO)
    {
        $this->cartId = Uuid::fromString($cartId);
        $this->moneyDTO = $moneyDTO;
    }

    public function getCartId(): UuidInterface
    {
        return $this->cartId;
    }

    public function getMoneyDTO(): MoneyDTO
    {
        return $this->moneyDTO;
    }
}
