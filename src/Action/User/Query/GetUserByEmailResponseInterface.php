<?php
namespace inklabs\kommerce\Action\User\Query;

use inklabs\kommerce\EntityDTO\Builder\UserDTOBuilder;

interface GetUserByEmailResponseInterface
{
    public function setUserDTOBuilder(UserDTOBuilder $productDTOBuilder);
}
