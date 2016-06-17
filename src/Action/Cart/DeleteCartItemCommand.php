<?php
namespace inklabs\kommerce\Action\Cart;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class DeleteCartItemCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $cartItemId;

    /**
     * @param string $cartItemId
     */
    public function __construct($cartItemId)
    {
        $this->cartItemId = Uuid::fromString($cartItemId);
    }

    public function getCartItemId()
    {
        return $this->cartItemId;
    }
}
