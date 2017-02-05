<?php
namespace inklabs\kommerce\ActionHandler\User;

use inklabs\kommerce\Action\User\GetUserByEmailQuery;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\EntityRepository\UserRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Query\QueryHandlerInterface;

final class GetUserByEmailHandler implements QueryHandlerInterface
{
    /** @var GetUserByEmailQuery */
    private $query;

    /** @var UserRepositoryInterface */
    private $userRepository;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    /** @var User */
    private $user;

    public function __construct(
        GetUserByEmailQuery $query,
        UserRepositoryInterface $userRepository,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->query = $query;
        $this->userRepository = $userRepository;
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
            $this->user = $this->userRepository->findOneByEmail(
                $this->query->getRequest()->getEmail()
            );
        }
        return $this->user;
    }
}
