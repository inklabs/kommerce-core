<?php
namespace inklabs\kommerce\ActionHandler\Tag;

use inklabs\kommerce\Action\Tag\GetTagQuery;
use inklabs\kommerce\Lib\Pricing;
use inklabs\kommerce\Service\TagServiceInterface;

final class GetTagHandler
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

    public function handle(GetTagQuery $query)
    {
        $tag = $this->tagService->findOneById($query->getRequest()->getTagId());

        $query->getResponse()->setTagDTO(
            $tag->getDTOBuilder()
                ->withAllData($this->pricing)
                ->build()
        );
    }
}
