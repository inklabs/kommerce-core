<?php
namespace inklabs\kommerce\Action\Tag\Handler;

use inklabs\kommerce\Action\Tag\ListTagsRequest;
use inklabs\kommerce\Action\Tag\Response\ListTagsResponseInterface;
use inklabs\kommerce\Lib\Command\TagServiceAwareInterface;
use inklabs\kommerce\Lib\Pricing;
use inklabs\kommerce\Service\TagServiceInterface;

class ListTagsHandler implements TagServiceAwareInterface
{
    /** @var TagServiceInterface */
    private $tagService;

    public function __construct(TagServiceInterface $tagService)
    {
        $this->tagService = $tagService;
    }

    public function handle(ListTagsRequest $command, ListTagsResponseInterface & $response)
    {
        $pagination = $command->getPagination();
        $tags = $this->tagService->getAllTags($command->getQueryString(), $pagination);

        foreach ($tags as $tag) {
            $response->addTagDTO(
                $tag->getDTOBuilder()
                ->build()
            );
        }
    }
}
