<?php
namespace inklabs\kommerce\EntityDTO;

class UserTokenDTO
{
    use IdDTOTrait, TimeDTOTrait;

    public $userAgent;
    public $expires;
    public $type;
    public $typeText;

    /** @var UserDTO */
    public $user;
}
