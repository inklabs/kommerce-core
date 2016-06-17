<?php
namespace inklabs\kommerce\Action\Cart;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class RemoveCartCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $cartId;

    /**
     * @param string $cartId
     */
    public function __construct($cartId)
    {
        $this->cartId = Uuid::fromString($cartId);
    }

    public function getCartId()
    {
        return $this->cartId;
    }
}
