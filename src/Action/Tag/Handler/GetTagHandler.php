<?php
namespace inklabs\kommerce\Action\Tag\Handler;

use inklabs\kommerce\Action\Tag\GetTagRequest;
use inklabs\kommerce\Action\Tag\Response\GetTagResponseInterface;
use inklabs\kommerce\Lib\Command\PricingAwareInterface;
use inklabs\kommerce\Lib\Command\TagServiceAwareInterface;
use inklabs\kommerce\Lib\Pricing;
use inklabs\kommerce\Service\TagServiceInterface;

class GetTagHandler implements TagServiceAwareInterface, PricingAwareInterface
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

    public function handle(GetTagRequest $request, GetTagResponseInterface & $response)
    {
        $tag = $this->tagService->findOneById($request->getTagId());

        $response->setTagDTO(
            $tag->getDTOBuilder()
                ->withAllData($this->pricing)
                ->build()
        );
    }
}
