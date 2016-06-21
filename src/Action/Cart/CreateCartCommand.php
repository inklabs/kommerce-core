<?php
namespace inklabs\kommerce\Action\Cart;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class CreateCartCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $cartId;

    /** @var string */
    private $remoteIp4;

    /** @var UuidInterface */
    private $userId;

    /** @var string */
    private $sessionId;

    /**
     * @param string $remoteIp4
     * @param string | null $userId
     * @param string | null $sessionId
     */
    public function __construct($remoteIp4, $userId = null, $sessionId = null)
    {
        $this->cartId = Uuid::uuid4();
        $this->remoteIp4 = (string) $remoteIp4;

        if ($userId !== null) {
            $this->userId = Uuid::fromString($userId);
        }

        if ($sessionId !== null) {
            $this->sessionId = (string) $sessionId;
        }
    }

    public function getCartId()
    {
        return $this->cartId;
    }

    public function getSessionId()
    {
        return $this->sessionId;
    }

    public function getRemoteIp4()
    {
        return $this->remoteIp4;
    }

    public function getUserId()
    {
        return $this->userId;
    }
}
