<?php
namespace inklabs\kommerce\ActionResponse\User;

use inklabs\kommerce\EntityDTO\Builder\UserDTOBuilder;

class GetUserByEmailResponse
{
    /** @var UserDTOBuilder */
    private $productDTOBuilder;

    public function setUserDTOBuilder(UserDTOBuilder $productDTOBuilder)
    {
        $this->productDTOBuilder = $productDTOBuilder;
    }

    public function getUserDTO()
    {
        return $this->productDTOBuilder
            ->build();
    }

    public function getUserDTOWithRolesAndTokens()
    {
        return $this->productDTOBuilder
            ->withRoles()
            ->withTokens()
            ->build();
    }
}
