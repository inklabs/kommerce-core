<?php
namespace inklabs\kommerce\ActionResponse\User;

use inklabs\kommerce\EntityDTO\Builder\UserDTOBuilder;
use inklabs\kommerce\Lib\Query\ResponseInterface;

final class GetUserResponse implements ResponseInterface
{
    /** @var UserDTOBuilder */
    private $userDTOBuilder;

    public function setUserDTOBuilder(UserDTOBuilder $userDTOBuilder)
    {
        $this->userDTOBuilder = $userDTOBuilder;
    }

    public function getUserDTO()
    {
        return $this->userDTOBuilder
            ->build();
    }

    public function getUserDTOWithRolesAndTokens()
    {
        return $this->userDTOBuilder
            ->withRoles()
            ->withTokens()
            ->build();
    }
}
