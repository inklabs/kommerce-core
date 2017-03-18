<?php
namespace inklabs\kommerce\ActionResponse\User;

use inklabs\kommerce\EntityDTO\Builder\PaginationDTOBuilder;
use inklabs\kommerce\EntityDTO\Builder\UserDTOBuilder;
use inklabs\kommerce\EntityDTO\PaginationDTO;
use inklabs\kommerce\EntityDTO\UserDTO;
use inklabs\kommerce\Lib\Query\ResponseInterface;

final class ListUsersResponse implements ResponseInterface
{
    /** @var UserDTOBuilder[] */
    private $userDTOBuilders = [];

    /** @var PaginationDTOBuilder */
    private $paginationDTOBuilder;

    public function setPaginationDTOBuilder(PaginationDTOBuilder $paginationDTOBuilder)
    {
        $this->paginationDTOBuilder = $paginationDTOBuilder;
    }

    public function addUserDTOBuilder(UserDTOBuilder $userDTOBuilder)
    {
        $this->userDTOBuilders[] = $userDTOBuilder;
    }

    /**
     * @return UserDTO[]
     */
    public function getUserDTOs()
    {
        $userDTOs = [];
        foreach ($this->userDTOBuilders as $userDTOBuilder) {
            $userDTOs[] = $userDTOBuilder->build();
        }
        return $userDTOs;
    }

    /**
     * @return PaginationDTO
     */
    public function getPaginationDTO()
    {
        return $this->paginationDTOBuilder->build();
    }
}
