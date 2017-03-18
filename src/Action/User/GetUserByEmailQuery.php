<?php
namespace inklabs\kommerce\Action\User;

use inklabs\kommerce\Lib\Query\QueryInterface;

final class GetUserByEmailQuery implements QueryInterface
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
