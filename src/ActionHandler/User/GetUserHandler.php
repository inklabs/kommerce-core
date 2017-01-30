<?php
namespace inklabs\kommerce\ActionHandler\User;

use inklabs\kommerce\Action\User\GetUserQuery;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\EntityRepository\UserRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Query\QueryHandlerInterface;

final class GetUserHandler implements QueryHandlerInterface
{
    /** @var GetUserQuery */
    private $query;

    /** @var UserRepositoryInterface */
    private $userRepository;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        GetUserQuery $query,
        UserRepositoryInterface $userRepository,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->query = $query;
        $this->userRepository = $userRepository;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyCanManageUser($this->query->getRequest()->getUserId());
    }

    public function handle()
    {
        $product = $this->userRepository->findOneById(
            $this->query->getRequest()->getUserId()
        );

        $this->query->getResponse()->setUserDTOBuilder(
            $this->dtoBuilderFactory->getUserDTOBuilder($product)
        );
    }
}
