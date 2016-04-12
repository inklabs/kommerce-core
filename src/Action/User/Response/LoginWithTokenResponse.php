<?php
namespace inklabs\kommerce\Action\User\Response;

use inklabs\kommerce\EntityDTO\UserDTO;

final class LoginWithTokenResponse implements LoginWithTokenResponseInterface
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
