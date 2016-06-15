<?php
namespace inklabs\kommerce\ActionHandler\User;

use inklabs\kommerce\Action\User\GetUserByEmailQuery;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\Service\UserServiceInterface;

final class GetUserByEmailHandler
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

    public function handle(GetUserByEmailQuery $query)
    {
        $product = $this->userService->findOneByEmail(
            $query->getRequest()->getEmail()
        );

        $query->getResponse()->setUserDTOBuilder(
            $this->dtoBuilderFactory->getUserDTOBuilder($product)
        );
    }
}
