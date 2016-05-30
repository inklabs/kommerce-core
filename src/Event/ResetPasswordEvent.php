<?php
namespace inklabs\kommerce\Event;

use inklabs\kommerce\Lib\Event\EventInterface;
use Ramsey\Uuid\UuidInterface;

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

    /**
     * @param UuidInterface $userId
     * @param string $email
     * @param string $fullName
     * @param string $token
     */
    public function __construct(UuidInterface $userId, $email, $fullName, $token)
    {
        $this->userId = $userId;
        $this->email = (string) $email;
        $this->fullName = (string) $fullName;
        $this->token = (string) $token;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function getFullName()
    {
        return $this->fullName;
    }
}
