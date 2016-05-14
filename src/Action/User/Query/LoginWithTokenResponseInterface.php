<?php
namespace inklabs\kommerce\Action\User\Query;

use inklabs\kommerce\EntityDTO\UserDTO;

interface LoginWithTokenResponseInterface
{
    public function setUserDTO(UserDTO $tagDTO);
    public function getUserDTO();
}
