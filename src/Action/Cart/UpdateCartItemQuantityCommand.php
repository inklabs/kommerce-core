<?php
namespace inklabs\kommerce\Action\Cart;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class UpdateCartItemQuantityCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $cartId;

    /** @var string */
    private $quantity;

    /**
     * @param string $cartId
     * @param int $quantity
     */
    public function __construct($cartId, $quantity)
    {
        $this->cartId = Uuid::fromString($cartId);
        $this->quantity = (int) $quantity;
    }

    public function getCartId()
    {
        return $this->cartId;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }
}
