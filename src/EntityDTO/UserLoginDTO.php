<?php
namespace inklabs\kommerce\EntityDTO;

use DateTime;

class UserLoginDTO
{
    use IdDTOTrait;

    public $email;
    public $ip4;
    public $result;
    public $resultText;

    /** @var DateTime */
    public $created;

    /** @var UserDTO */
    public $user;
}
