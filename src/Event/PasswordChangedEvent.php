<?php
namespace inklabs\kommerce\Event;

use inklabs\kommerce\Lib\Event\EventInterface;

class PasswordChangedEvent implements EventInterface
{
    /** @var int */
    private $userId;

    /** @var string */
    private $email;

    /** @var string */
    private $fullName;

    /**
     * @param int $userId
     * @param string $email
     * @param string $fullName
     */
    public function __construct($userId, $email, $fullName)
    {
        $this->userId = (int) $userId;
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
