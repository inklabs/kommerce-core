<?php
namespace inklabs\kommerce\EntityDTO;

class UserDTO
{
    public $id;
    public $encodedId;
    public $externalId;
    public $email;
    public $firstName;
    public $lastName;
    public $totalLogins;
    public $lastLogin;
    public $status;
    public $statusText;
    public $created;
    public $updated;

    /** @var UserRoleDTO[] */
    public $roles = [];

    /** @var UserTokenDTO[] */
    public $tokens = [];

    /** @var UserLoginDTO[] */
    public $logins = [];
}
