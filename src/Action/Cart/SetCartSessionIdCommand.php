<?php
namespace inklabs\kommerce\Action\Cart;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class SetCartSessionIdCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $cartId;

    /** @var string */
    private $sessionId;

    public function __construct(string $cartId, string $sessionId)
    {
        $this->cartId = Uuid::fromString($cartId);
        $this->sessionId = $sessionId;
    }

    public function getCartId(): UuidInterface
    {
        return $this->cartId;
    }

    public function getSessionId(): string
    {
        return $this->sessionId;
    }
}
