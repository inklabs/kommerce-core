<?php
namespace inklabs\kommerce\Action\Cart;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class SetCartUserCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $cartId;

    /** @var UuidInterface */
    private $userId;

    /**
     * @param string $cartId
     * @param string $userId
     */
    public function __construct(string $cartId, string $userId)
    {
        $this->cartId = Uuid::fromString($cartId);
        $this->userId = Uuid::fromString($userId);
    }

    public function getCartId(): UuidInterface
    {
        return $this->cartId;
    }

    public function getUserId(): UuidInterface
    {
        return $this->userId;
    }
}
