<?php
namespace inklabs\kommerce\Action\Tag\Handler;

use inklabs\kommerce\Action\Tag\ListTagsRequest;
use inklabs\kommerce\Action\Tag\Response\ListTagsResponseInterface;
use inklabs\kommerce\Lib\Command\PricingAwareInterface;
use inklabs\kommerce\Lib\Command\TagServiceAwareInterface;
use inklabs\kommerce\Lib\Pricing;
use inklabs\kommerce\Service\TagServiceInterface;

class ListTagsHandler implements TagServiceAwareInterface, PricingAwareInterface
{
    /** @var TagServiceInterface */
    private $tagService;

    /** @var Pricing */
    private $pricing;

    public function __construct(TagServiceInterface $tagService, Pricing $pricing)
    {
        $this->tagService = $tagService;
        $this->pricing = $pricing;
    }

    public function handle(ListTagsRequest $command, ListTagsResponseInterface & $response)
    {
        $pagination = $command->getPagination();
        $tags = $this->tagService->getAllTags($command->getQueryString());

        foreach ($tags as $tag) {
            $response->addTagDTO(
                $tag->getDTOBuilder()
                ->withAllData($this->pricing)
                ->build()
            );
        }
    }
}
