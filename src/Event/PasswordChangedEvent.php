<?php
namespace inklabs\kommerce\Event;

use inklabs\kommerce\Lib\Event\EventInterface;
use inklabs\kommerce\Lib\UuidInterface;

class PasswordChangedEvent implements EventInterface
{
    /** @var UuidInterface */
    private $userId;

    /** @var string */
    private $email;

    /** @var string */
    private $fullName;

    /**
     * @param UuidInterface $userId
     * @param string $email
     * @param string $fullName
     */
    public function __construct(UuidInterface $userId, $email, $fullName)
    {
        $this->userId = $userId;
        $this->email = (string) $email;
        $this->fullName = (string) $fullName;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getFullName()
    {
        return $this->fullName;
    }
}
