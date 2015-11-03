<?php
namespace inklabs\kommerce\EntityDTO;

class UserDTO
{
    use IdDTOTrait, TimeDTOTrait;

    public $externalId;
    public $email;
    public $firstName;
    public $lastName;
    public $totalLogins;
    public $lastLogin;
    public $status;
    public $statusText;

    /** @var UserRoleDTO[] */
    public $userRoles = [];

    /** @var UserTokenDTO[] */
    public $userTokens = [];

    /** @var UserLoginDTO[] */
    public $userLogins = [];
}
