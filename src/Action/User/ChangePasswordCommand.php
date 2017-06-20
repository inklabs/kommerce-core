<?php
namespace inklabs\kommerce\Action\User;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class ChangePasswordCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $userId;

    /** @var string */
    private $password;

    public function __construct(string $userId, string $password)
    {
        $this->userId = Uuid::fromString($userId);
        $this->password = (string) $password;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getPassword()
    {
        return $this->password;
    }
}
