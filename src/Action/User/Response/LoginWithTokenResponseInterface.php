<?php
namespace inklabs\kommerce\Action\User\Response;

use inklabs\kommerce\EntityDTO\UserDTO;
use inklabs\kommerce\Lib\Query\ResponseInterface;

interface LoginWithTokenResponseInterface extends ResponseInterface
{
    public function setUserDTO(UserDTO $tagDTO);
    public function getUserDTO();
}
