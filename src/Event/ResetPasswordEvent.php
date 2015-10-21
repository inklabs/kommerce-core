<?php
namespace inklabs\kommerce\Event;

use inklabs\kommerce\Lib\Event\EventInterface;

class ResetPasswordEvent implements EventInterface
{
    /** @var int */
    private $userId;

    /** @var string */
    private $email;

    /** @var string */
    private $fullName;

    /** @var string */
    private $token;

    /**
     * @param int $userId
     * @param string $email
     * @param string $token
     */
    public function __construct($userId, $email, $fullName, $token)
    {
        $this->userId = (int) $userId;
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
