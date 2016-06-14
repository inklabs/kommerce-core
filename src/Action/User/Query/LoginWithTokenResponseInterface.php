<?php
namespace inklabs\kommerce\Action\User\Query;

use inklabs\kommerce\EntityDTO\Builder\UserDTOBuilder;

interface LoginWithTokenResponseInterface
{
    public function setUserDTOBuilder(UserDTOBuilder $userDTOBuilder);
}
