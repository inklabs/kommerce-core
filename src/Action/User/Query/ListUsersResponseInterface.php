<?php
namespace inklabs\kommerce\Action\User\Query;

use inklabs\kommerce\EntityDTO\Builder\PaginationDTOBuilder;
use inklabs\kommerce\EntityDTO\Builder\UserDTOBuilder;

interface ListUsersResponseInterface
{
    public function setPaginationDTOBuilder(PaginationDTOBuilder$paginationDTOBuilder);
    public function addUserDTOBuilder(UserDTOBuilder $userDTOBuilder);
}
