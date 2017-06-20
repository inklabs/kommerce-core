<?php
namespace inklabs\kommerce\Action\Cart;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class DeleteCartItemCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $cartItemId;

    public function __construct(string $cartItemId)
    {
        $this->cartItemId = Uuid::fromString($cartItemId);
    }

    public function getCartItemId(): UuidInterface
    {
        return $this->cartItemId;
    }
}
