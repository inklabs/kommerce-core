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
    public function __construct($cartId, $userId)
    {
        $this->cartId = Uuid::fromString($cartId);
        $this->userId = Uuid::fromString($userId);
    }

    public function getCartId()
    {
        return $this->cartId;
    }

    public function getUserId()
    {
        return $this->userId;
    }
}
