<?php
namespace inklabs\kommerce\EntityDTO;

class UserLoginDTO
{
    public $id;
    public $encodedId;
    public $email;
    public $ip4;
    public $result;
    public $resultText;
    public $created;

    /** @var UserDTO */
    public $user;
}
