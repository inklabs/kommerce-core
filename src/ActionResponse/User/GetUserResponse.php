<?php
namespace inklabs\kommerce\ActionResponse\User;

use inklabs\kommerce\EntityDTO\Builder\UserDTOBuilder;
use inklabs\kommerce\EntityDTO\UserDTO;
use inklabs\kommerce\Lib\Query\ResponseInterface;

final class GetUserResponse implements ResponseInterface
{
    /** @var UserDTOBuilder */
    private $userDTOBuilder;

    public function setUserDTOBuilder(UserDTOBuilder $userDTOBuilder): void
    {
        $this->userDTOBuilder = $userDTOBuilder;
    }

    public function getUserDTO(): UserDTO
    {
        return $this->userDTOBuilder
            ->build();
    }

    public function getUserDTOWithRolesAndTokens(): UserDTO
    {
        return $this->userDTOBuilder
            ->withRoles()
            ->withTokens()
            ->build();
    }
}
