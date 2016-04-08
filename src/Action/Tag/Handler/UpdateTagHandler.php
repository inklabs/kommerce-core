<?php
namespace inklabs\kommerce\Action\Tag\Handler;

use inklabs\kommerce\Action\Tag\UpdateTagCommand;
use inklabs\kommerce\EntityDTO\Builder\TagDTOBuilder;
use inklabs\kommerce\Service\TagServiceInterface;

final class UpdateTagHandler
{
    /** @var TagServiceInterface */
    protected $tagService;

    public function __construct(TagServiceInterface $tagService)
    {
        $this->tagService = $tagService;
    }

    public function handle(UpdateTagCommand $command)
    {
        $tagDTO = $command->getTagDTO();
        $tag = $this->tagService->findOneById($tagDTO->id);
        TagDTOBuilder::setFromDTO($tag, $tagDTO);

        $this->tagService->update($tag);
    }
}
