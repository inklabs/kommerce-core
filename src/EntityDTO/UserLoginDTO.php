<?php
namespace inklabs\kommerce\EntityDTO;

use DateTime;

class UserLoginDTO
{
    use IdDTOTrait;

    /** @var string */
    public $email;

    /** @var string */
    public $ip4;

    /** @var int */
    public $result;

    /** @var string */
    public $resultText;

    /** @var DateTime */
    public $created;

    /** @var UserDTO */
    public $user;

    /** @var UserTokenDTO */
    public $userToken;
}
