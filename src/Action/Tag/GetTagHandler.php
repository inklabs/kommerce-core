<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\Lib\Pricing;
use inklabs\kommerce\Service\TagServiceInterface;

class GetTagHandler
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

    public function handle(GetTagRequest $command)
    {
        $tag = $this->tagService->findOneById($command->getTagId());

        return new GetTagResponse(
            $tag->getDTOBuilder()
                ->withAllData($this->pricing)
                ->build()
        );
    }
}
