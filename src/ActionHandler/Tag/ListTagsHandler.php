<?php
namespace inklabs\kommerce\ActionHandler\Tag;

use inklabs\kommerce\Action\Tag\ListTagsQuery;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Service\TagServiceInterface;

final class ListTagsHandler
{
    /** @var TagServiceInterface */
    private $tagService;

    public function __construct(TagServiceInterface $tagService)
    {
        $this->tagService = $tagService;
    }

    public function handle(ListTagsQuery $query)
    {
        $paginationDTO = $query->getRequest()->getPaginationDTO();
        $pagination = new Pagination($paginationDTO->maxResults, $paginationDTO->page);

        $tags = $this->tagService->getAllTags($query->getRequest()->getQueryString(), $pagination);

        $query->getResponse()->setPaginationDTO(
            $pagination->getDTOBuilder()
                ->build()
        );

        foreach ($tags as $tag) {
            $query->getResponse()->addTagDTO(
                $tag->getDTOBuilder()
                    ->build()
            );
        }
    }
}
