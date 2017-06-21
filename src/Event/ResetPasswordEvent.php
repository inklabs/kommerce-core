<?php
namespace inklabs\kommerce\Event;

use inklabs\kommerce\Lib\Event\EventInterface;
use inklabs\kommerce\Lib\UuidInterface;

class ResetPasswordEvent implements EventInterface
{
    /** @var UuidInterface */
    private $userId;

    /** @var string */
    private $email;

    /** @var string */
    private $fullName;

    /** @var string */
    private $token;

    public function __construct(UuidInterface $userId, string $email, string $fullName, string $token)
    {
        $this->userId = $userId;
        $this->email = $email;
        $this->fullName = $fullName;
        $this->token = $token;
    }

    public function getUserId(): UuidInterface
    {
        return $this->userId;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }
}
