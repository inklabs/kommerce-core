<?php
namespace inklabs\kommerce\ActionHandler\Attribute;

use inklabs\kommerce\Action\Attribute\ListAttributesQuery;
use inklabs\kommerce\ActionResponse\Attribute\ListAttributesResponse;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\EntityRepository\AttributeRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Query\QueryHandlerInterface;

final class ListAttributesHandler implements QueryHandlerInterface
{
    /** @var ListAttributesQuery */
    private $query;

    /** @var AttributeRepositoryInterface */
    private $attributeRepository;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        ListAttributesQuery $query,
        AttributeRepositoryInterface $attributeRepository,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->query = $query;
        $this->attributeRepository = $attributeRepository;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $response = new ListAttributesResponse();

        $paginationDTO = $this->query->getPaginationDTO();
        $pagination = new Pagination($paginationDTO->maxResults, $paginationDTO->page);

        $coupons = $this->attributeRepository->getAllAttributes($this->query->getQueryString(), $pagination);

        $response->setPaginationDTOBuilder(
            $this->dtoBuilderFactory->getPaginationDTOBuilder($pagination)
        );

        foreach ($coupons as $coupon) {
            $response->addAttributeDTOBuilder(
                $this->dtoBuilderFactory->getAttributeDTOBuilder($coupon)
            );
        }

        return $response;
    }
}
