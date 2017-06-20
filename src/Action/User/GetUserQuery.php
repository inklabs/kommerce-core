<?php
namespace inklabs\kommerce\Action\User;

use inklabs\kommerce\Lib\Query\QueryInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class GetUserQuery implements QueryInterface
{
    /** @var UuidInterface */
    private $userId;

    public function __construct(string $userId)
    {
        $this->userId = Uuid::fromString($userId);
    }

    public function getUserId(): UuidInterface
    {
        return $this->userId;
    }
}
