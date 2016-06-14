<?php
namespace inklabs\kommerce\ActionHandler\Tag;

use inklabs\kommerce\Action\Tag\GetTagQuery;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\Service\TagServiceInterface;

final class GetTagHandler
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

    public function handle(GetTagQuery $query)
    {
        $tag = $this->tagService->findOneById(
            $query->getRequest()->getTagId()
        );

        $query->getResponse()->setTagDTOBuilder(
            $this->dtoBuilderFactory->getTagDTOBuilder($tag)
        );
    }
}
