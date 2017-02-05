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

    /**
     * @param string $cartItemId
     * @param int $quantity
     */
    public function __construct($cartItemId, $quantity)
    {
        $this->cartItemId = Uuid::fromString($cartItemId);
        $this->quantity = (int) $quantity;
    }

    public function getCarItemtId()
    {
        return $this->cartItemId;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }
}
