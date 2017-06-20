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

    /** @var string|null */
    private $sessionId;

    public function __construct(string $remoteIp4, ?string $userId = null, ?string $sessionId = null)
    {
        $this->cartId = Uuid::uuid4();
        $this->remoteIp4 = $remoteIp4;
        $this->sessionId = $sessionId;

        if ($userId !== null) {
            $this->userId = Uuid::fromString($userId);
        }
    }

    public function getCartId(): UuidInterface
    {
        return $this->cartId;
    }

    public function getSessionId(): ?string
    {
        return $this->sessionId;
    }

    public function getRemoteIp4(): string
    {
        return $this->remoteIp4;
    }

    public function getUserId(): UuidInterface
    {
        return $this->userId;
    }
}
