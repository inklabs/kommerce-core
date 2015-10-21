<?php
namespace inklabs\kommerce\Event;

use inklabs\kommerce\Lib\Event\EventInterface;

class ResetPasswordEvent implements EventInterface
{
    /** @var */
    private $userId;

    /** @var */
    private $email;

    /** @var string */
    private $token;

    /**
     * @param int $userId
     * @param string $email
     * @param string $token
     */
    public function __construct($userId, $email, $token)
    {
        $this->userId = (int) $userId;
        $this->email = (string) $email;
        $this->token = (string) $token;
    }
}
