<?php
namespace inklabs\kommerce\ActionHandler\User;

use inklabs\kommerce\Action\User\LoginWithTokenQuery;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\Service\UserServiceInterface;

final class LoginWithTokenHandler
{
    /** @var UserServiceInterface */
    private $userService;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        UserServiceInterface $userService,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->userService = $userService;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    public function handle(LoginWithTokenQuery $query)
    {
        $request = $query->getRequest();

        $user = $this->userService->loginWithToken(
            $request->getEmail(),
            $request->getToken(),
            $request->getIp4()
        );

        $query->getResponse()->setUserDTOBuilder(
            $this->dtoBuilderFactory->getUserDTOBuilder($user)
        );
    }
}
