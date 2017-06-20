<?php
namespace inklabs\kommerce\ActionHandler\Attribute;

use inklabs\kommerce\Action\Attribute\GetAttributeValueQuery;
use inklabs\kommerce\ActionResponse\Attribute\GetAttributeValueResponse;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\EntityRepository\AttributeValueRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Query\QueryHandlerInterface;

final class GetAttributeValueHandler implements QueryHandlerInterface
{
    /** @var GetAttributeValueQuery */
    private $query;

    /** @var AttributeValueRepositoryInterface */
    private $attributeValueRepository;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        GetAttributeValueQuery $query,
        AttributeValueRepositoryInterface $attributeValueRepository,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->query = $query;
        $this->attributeValueRepository = $attributeValueRepository;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext): void
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $response = new GetAttributeValueResponse();

        $attributeValue = $this->attributeValueRepository->findOneById(
            $this->query->getAttributeValueId()
        );

        $response->setAttributeValueDTOBuilder(
            $this->dtoBuilderFactory->getAttributeValueDTOBuilder($attributeValue)
        );

        return $response;
    }
}
