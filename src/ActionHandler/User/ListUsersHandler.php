<?php
namespace inklabs\kommerce\ActionHandler\User;

use inklabs\kommerce\Action\User\ListUsersQuery;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\Service\UserServiceInterface;

final class ListUsersHandler
{
    /** @var UserServiceInterface */
    private $userService;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(UserServiceInterface $userService, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->userService = $userService;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    public function handle(ListUsersQuery $query)
    {
        $paginationDTO = $query->getRequest()->getPaginationDTO();
        $pagination = new Pagination($paginationDTO->maxResults, $paginationDTO->page);

        $users = $this->userService->getAllUsers(
            $query->getRequest()->getQueryString(),
            $pagination
        );

        $query->getResponse()->setPaginationDTOBuilder(
            $this->dtoBuilderFactory->getPaginationDTOBuilder($pagination)
        );

        foreach ($users as $user) {
            $query->getResponse()->addUserDTOBuilder(
                $this->dtoBuilderFactory->getUserDTOBuilder($user)
            );
        }
    }
}
