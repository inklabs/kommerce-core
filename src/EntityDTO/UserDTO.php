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
    public $roles = [];

    /** @var UserTokenDTO[] */
    public $tokens = [];

    /** @var UserLoginDTO[] */
    public $logins = [];
}
