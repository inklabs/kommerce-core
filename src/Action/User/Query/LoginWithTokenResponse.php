<?php
namespace inklabs\kommerce\Action\User\Query;

use inklabs\kommerce\EntityDTO\Builder\UserDTOBuilder;

class LoginWithTokenResponse implements LoginWithTokenResponseInterface
{
    /** @var UserDTOBuilder */
    protected $userDTOBuilder;

    public function setUserDTOBuilder(UserDTOBuilder $userDTOBuilder)
    {
        $this->userDTOBuilder = $userDTOBuilder;
    }

    public function getUserDTO()
    {
        return $this->userDTOBuilder
            ->withRoles()
            ->withTokens()
            ->build();
    }
}
