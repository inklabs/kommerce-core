<?php
namespace inklabs\kommerce\EntityDTO;

class UserTokenDTO
{
    public $id;
    public $userAgent;
    public $token;
    public $expires;
    public $type;
    public $typeText;
    public $created;
    public $updated;

    /** @var UserDTO */
    public $user;
}
