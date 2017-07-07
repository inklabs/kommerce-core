<?php
namespace inklabs\kommerce\ActionHandler\Attribute;

use inklabs\kommerce\Action\Attribute\GetProductAttributesByAttributeValueQuery;
use inklabs\kommerce\ActionResponse\Attribute\GetProductAttributesByAttributeValueResponse;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\EntityRepository\ProductAttributeRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\PricingInterface;
use inklabs\kommerce\Lib\Query\QueryHandlerInterface;

final class GetProductAttributesByAttributeValueHandler implements QueryHandlerInterface
{
    /** @var GetProductAttributesByAttributeValueQuery */
    private $query;

    /** @var PricingInterface */
    private $pricing;

    /** @var ProductAttributeRepositoryInterface */
    private $productAttributeRepository;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        GetProductAttributesByAttributeValueQuery $query,
        PricingInterface $pricing,
        ProductAttributeRepositoryInterface $productAttributeRepository,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->query = $query;
        $this->pricing = $pricing;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
        $this->productAttributeRepository = $productAttributeRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext): void
    {
        $authorizationContext->verifyCanMakeRequests();
    }

    public function handle()
    {
        $response = new GetProductAttributesByAttributeValueResponse($this->pricing);

        $paginationDTO = $this->query->getPaginationDTO();
        $pagination = new Pagination($paginationDTO->maxResults, $paginationDTO->page);

        $productAttributes = $this->productAttributeRepository->getByAttributeValue(
            $this->query->getAttributeValueId(),
            $pagination
        );

        $response->setPaginationDTOBuilder(
            $this->dtoBuilderFactory->getPaginationDTOBuilder($pagination)
        );

        foreach ($productAttributes as $productAttribute) {
            $response->addProductAttributeDTOBuilder(
                $this->dtoBuilderFactory->getProductAttributeDTOBuilder($productAttribute)
            );
        }

        return $response;
    }
}
