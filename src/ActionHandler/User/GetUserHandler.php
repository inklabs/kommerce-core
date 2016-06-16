<?php
namespace inklabs\kommerce\ActionHandler\User;

use inklabs\kommerce\Action\User\GetUserQuery;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\Service\UserServiceInterface;

final class GetUserHandler
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

    public function handle(GetUserQuery $query)
    {
        $product = $this->userService->findOneById(
            $query->getRequest()->getUserId()
        );

        $query->getResponse()->setUserDTOBuilder(
            $this->dtoBuilderFactory->getUserDTOBuilder($product)
        );
    }
}
