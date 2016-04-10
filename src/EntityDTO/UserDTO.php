<?php
namespace inklabs\kommerce\EntityDTO;

use DateTime;

class UserDTO
{
    use IdDTOTrait, TimeDTOTrait;

    /** @var string */
    public $externalId;

    /** @var string */
    public $email;

    /** @var string */
    public $firstName;

    /** @var string */
    public $lastName;

    /** @var int */
    public $totalLogins;

    /** @var DateTime */
    public $lastLogin;

    /** @var UserStatusTypeDTO */
    public $status;

    /** @var UserRoleDTO[] */
    public $userRoles = [];

    /** @var UserTokenDTO[] */
    public $userTokens = [];

    /** @var UserLoginDTO[] */
    public $userLogins = [];
}
