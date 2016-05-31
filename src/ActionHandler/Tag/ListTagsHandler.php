<?php
namespace inklabs\kommerce\ActionHandler\Tag;

use inklabs\kommerce\Action\Tag\ListTagsQuery;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\Service\TagServiceInterface;

final class ListTagsHandler
{
    /** @var TagServiceInterface */
    private $tagService;

    /** @var DTOBuilderFactoryInterface */
    private $dtoBuilderFactory;

    public function __construct(TagServiceInterface $tagService, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->tagService = $tagService;
        $this->dtoBuilderFactory = $dtoBuilderFactory;
    }

    public function handle(ListTagsQuery $query)
    {
        $paginationDTO = $query->getRequest()->getPaginationDTO();
        $pagination = new Pagination($paginationDTO->maxResults, $paginationDTO->page);

        $tags = $this->tagService->getAllTags($query->getRequest()->getQueryString(), $pagination);

        $query->getResponse()->setPaginationDTOBuilder(
            $this->dtoBuilderFactory->getPaginationDTOBuilder($pagination)
        );

        foreach ($tags as $tag) {
            $query->getResponse()->addTagDTOBuilder(
                $this->dtoBuilderFactory->getTagDTOBuilder($tag)
            );
        }
    }
}
