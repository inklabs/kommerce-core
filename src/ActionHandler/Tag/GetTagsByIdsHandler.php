<?php
namespace inklabs\kommerce\ActionHandler\Tag;

use inklabs\kommerce\Action\Tag\GetTagsByIdsQuery;
use inklabs\kommerce\EntityDTO\Builder\DTOBuilderFactoryInterface;
use inklabs\kommerce\Service\TagServiceInterface;

final class GetTagsByIdsHandler
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

    public function handle(GetTagsByIdsQuery $query)
    {
        $tags = $this->tagService->getTagsByIds(
            $query->getRequest()->getTagIds()
        );

        foreach ($tags as $tag) {
            $query->getResponse()->addTagDTOBuilder(
                $this->dtoBuilderFactory->getTagDTOBuilder($tag)
            );
        }
    }
}
