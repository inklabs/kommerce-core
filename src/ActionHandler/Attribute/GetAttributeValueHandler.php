<?php
namespace inklabs\kommerce\ActionHandler\Attribute;

use inklabs\kommerce\Action\Attribute\GetAttributeValueQuery;
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

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $attributeValue = $this->attributeValueRepository->findOneById(
            $this->query->getRequest()->getAttributeValueId()
        );

        $this->query->getResponse()->setAttributeValueDTOBuilder(
            $this->dtoBuilderFactory->getAttributeValueDTOBuilder($attributeValue)
        );
    }
}
