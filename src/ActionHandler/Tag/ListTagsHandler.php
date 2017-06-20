<?php
namespace inklabs\kommerce\ActionHandler\Tag;

use inklabs\kommerce\Action\Tag\ListTagsQuery;
use inklabs\kommerce\ActionResponse\Tag\ListTagsResponse;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\EntityRepository\TagRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Query\QueryHandlerInterface;

final class ListTagsHandler implements QueryHandlerInterface
{
    /** @var ListTagsQuery */
    private $query;

    /** @var TagRepositoryInterface */
    private $tagRepository;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(
        ListTagsQuery $query,
        TagRepositoryInterface $tagRepository,
        DTOBuilderFactoryInterface $dtoBuilderFactory
    ) {
        $this->query = $query;
        $this->tagRepository = $tagRepository;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext): void
    {
        $authorizationContext->verifyCanMakeRequests();
    }

    public function handle()
    {
        $response = new ListTagsResponse();

        $paginationDTO = $this->query->getPaginationDTO();
        $pagination = new Pagination($paginationDTO->maxResults, $paginationDTO->page);

        $tags = $this->tagRepository->getAllTags(
            $this->query->getQueryString(),
            $pagination
        );

        $response->setPaginationDTOBuilder(
            $this->dtoBuilderFactory->getPaginationDTOBuilder($pagination)
        );

        foreach ($tags as $tag) {
            $response->addTagDTOBuilder(
                $this->dtoBuilderFactory->getTagDTOBuilder($tag)
            );
        }

        return $response;
    }
}
