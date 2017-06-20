<?php
namespace inklabs\kommerce\ActionHandler\Attribute;

use inklabs\kommerce\Action\Attribute\GetAttributeQuery;
use inklabs\kommerce\ActionResponse\Attribute\GetAttributeResponse;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\EntityRepository\AttributeRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Query\QueryHandlerInterface;

final class GetAttributeHandler implements QueryHandlerInterface
{
    /** @var GetAttributeQuery */
    private $query;

    /** @var AttributeRepositoryInterface */
    private $attributeRepository;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        GetAttributeQuery $query,
        AttributeRepositoryInterface $attributeRepository,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->query = $query;
        $this->attributeRepository = $attributeRepository;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext): void
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $response = new GetAttributeResponse();

        $attribute = $this->attributeRepository->findOneById(
            $this->query->getAttributeId()
        );

        $response->setAttributeDTOBuilder(
            $this->dtoBuilderFactory->getAttributeDTOBuilder($attribute)
        );

        return $response;
    }
}
