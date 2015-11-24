<?php
namespace inklabs\kommerce\Action\Tag\Handler;

use inklabs\kommerce\Action\Tag\ListTagsRequest;
use inklabs\kommerce\Action\Tag\Response\ListTagsResponseInterface;
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

    public function handle(ListTagsRequest $request, ListTagsResponseInterface & $response)
    {
        $paginationDTO = $request->getPaginationDTO();
        $pagination = new Pagination($paginationDTO->maxResults, $paginationDTO->page);

        $tags = $this->tagService->getAllTags($request->getQueryString(), $pagination);

        $response->setPaginationDTO(
            $pagination->getDTOBuilder()
                ->build()
        );

        foreach ($tags as $tag) {
            $response->addTagDTO(
                $tag->getDTOBuilder()
                    ->build()
            );
        }
    }
}
