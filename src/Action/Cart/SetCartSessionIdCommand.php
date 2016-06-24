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

    /**
     * @param string $cartId
     * @param string $sessionId
     */
    public function __construct($cartId, $sessionId)
    {
        $this->cartId = Uuid::fromString($cartId);
        $this->sessionId = (string) $sessionId;
    }

    public function getCartId()
    {
        return $this->cartId;
    }

    public function getSessionId()
    {
        return $this->sessionId;
    }
}
