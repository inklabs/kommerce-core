<?php
namespace inklabs\kommerce\ActionHandler\User;

use inklabs\kommerce\Action\User\GetUserByEmailQuery;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Query\QueryHandlerInterface;
use inklabs\kommerce\Service\UserServiceInterface;

final class GetUserByEmailHandler implements QueryHandlerInterface
{
    /** @var GetUserByEmailQuery */
    private $query;

    /** @var UserServiceInterface */
    private $userService;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    /** @var User */
    private $user;

    public function __construct(
        GetUserByEmailQuery $query,
        UserServiceInterface $userService,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->query = $query;
        $this->userService = $userService;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyCanManageUser(
            $this->getUser()->getId()
        );
    }

    public function handle()
    {
        $this->query->getResponse()->setUserDTOBuilder(
            $this->dtoBuilderFactory->getUserDTOBuilder($this->getUser())
        );
    }

    private function getUser()
    {
        if ($this->user === null) {
            $this->user = $this->userService->findOneByEmail(
                $this->query->getRequest()->getEmail()
            );
        }
        return $this->user;
    }
}
