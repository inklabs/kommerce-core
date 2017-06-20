<?php
namespace inklabs\kommerce\Action\User;

use inklabs\kommerce\Lib\Query\QueryInterface;

final class GetUserByEmailQuery implements QueryInterface
{
    /** @var string */
    private $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
