<?php
namespace inklabs\kommerce\Action\User\Query;

final class GetUserByEmailRequest
{
    /** @var string */
    private $email;

    /**
     * @param string $email
     */
    public function __construct($email)
    {
        $this->email = (string) $email;
    }

    public function getEmail()
    {
        return $this->email;
    }
}
