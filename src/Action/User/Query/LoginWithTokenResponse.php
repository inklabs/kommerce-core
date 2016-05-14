<?php
namespace inklabs\kommerce\Action\User\Query;

use inklabs\kommerce\EntityDTO\UserDTO;

class LoginWithTokenResponse implements LoginWithTokenResponseInterface
{
    /** @var UserDTO */
    protected $userDTO;

    public function setUserDTO(UserDTO $userDTO)
    {
        $this->userDTO = $userDTO;
    }

    public function getUserDTO()
    {
        return $this->userDTO;
    }
}
