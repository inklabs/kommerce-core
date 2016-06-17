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
     * @param string $cartIdString
     * @param string $userIdString
     */
    public function __construct($cartIdString, $userIdString)
    {
        $this->cartId = Uuid::fromString($cartIdString);
        $this->userId = Uuid::fromString($userIdString);
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
