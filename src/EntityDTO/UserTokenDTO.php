<?php
namespace inklabs\kommerce\EntityDTO;

class UserTokenDTO
{
    use IdDTOTrait, TimeDTOTrait;

    /** @var string */
    public $userAgent;

    /** @var int */
    public $expires;

    /** @var UserTokenTypeDTO */
    public $type;

    /** @var UserDTO */
    public $user;
}
