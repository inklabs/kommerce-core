<?php
namespace inklabs\kommerce\EntityDTO;

class UserTokenDTO
{
    use IdDTOTrait, TimeDTOTrait;

    /** @var string */
    public $userAgent;

    /** @var int */
    public $expires;

    /** @var int */
    public $type;

    /** @var string */
    public $typeText;

    /** @var UserDTO */
    public $user;
}
