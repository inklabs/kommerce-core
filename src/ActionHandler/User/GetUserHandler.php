<?php
namespace inklabs\kommerce\ActionHandler\User;

use inklabs\kommerce\Action\User\GetUserQuery;
use inklabs\kommerce\ActionResponse\User\GetUserResponse;
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

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext): void
    {
        $authorizationContext->verifyCanManageUser($this->query->getUserId());
    }

    public function handle()
    {
        $response = new GetUserResponse();

        $product = $this->userRepository->findOneById(
            $this->query->getUserId()
        );

        $response->setUserDTOBuilder(
            $this->dtoBuilderFactory->getUserDTOBuilder($product)
        );

        return $response;
    }
}
