<?php
namespace inklabs\kommerce\ActionResponse\User;

use inklabs\kommerce\EntityDTO\Builder\UserDTOBuilder;
use inklabs\kommerce\EntityDTO\UserDTO;
use inklabs\kommerce\Lib\Query\ResponseInterface;

final class GetUserByEmailResponse implements ResponseInterface
{
    /** @var UserDTOBuilder */
    private $productDTOBuilder;

    public function setUserDTOBuilder(UserDTOBuilder $productDTOBuilder): void
    {
        $this->productDTOBuilder = $productDTOBuilder;
    }

    public function getUserDTO(): UserDTO
    {
        return $this->productDTOBuilder
            ->build();
    }

    public function getUserDTOWithRolesAndTokens(): UserDTO
    {
        return $this->productDTOBuilder
            ->withRoles()
            ->withTokens()
            ->build();
    }
}
