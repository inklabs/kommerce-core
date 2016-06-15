<?php
namespace inklabs\kommerce\Action\Cart\Query;

use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class GetCartByUserIdRequest
{
    /** @var UuidInterface */
    private $userId;

    /**
     * @param string $userIdString
     */
    public function __construct($userIdString)
    {
        $this->userId = Uuid::fromString($userIdString);
    }

    public function getUserId()
    {
        return $this->userId;
    }
}
