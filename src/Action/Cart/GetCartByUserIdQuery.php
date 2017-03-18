<?php
namespace inklabs\kommerce\Action\Cart;

use inklabs\kommerce\Lib\Query\QueryInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class GetCartByUserIdQuery implements QueryInterface
{
    /** @var UuidInterface */
    private $userId;

    /**
     * @param string $userId
     */
    public function __construct($userId)
    {
        $this->userId = Uuid::fromString($userId);
    }

    public function getUserId()
    {
        return $this->userId;
    }
}
