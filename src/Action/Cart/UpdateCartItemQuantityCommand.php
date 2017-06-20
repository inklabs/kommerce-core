<?php
namespace inklabs\kommerce\Action\Cart;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class UpdateCartItemQuantityCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $cartItemId;

    /** @var string */
    private $quantity;

    public function __construct(string $cartItemId, int $quantity)
    {
        $this->cartItemId = Uuid::fromString($cartItemId);
        $this->quantity = $quantity;
    }

    public function getCarItemtId(): UuidInterface
    {
        return $this->cartItemId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
