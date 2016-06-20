<?php
namespace inklabs\kommerce\Action\User\Query;

use inklabs\kommerce\EntityDTO\Builder\UserDTOBuilder;

interface GetUserResponseInterface
{
    public function setUserDTOBuilder(UserDTOBuilder $userDTOBuilder);
}
