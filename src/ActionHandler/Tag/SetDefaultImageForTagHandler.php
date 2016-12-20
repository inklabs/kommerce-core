<?php
namespace inklabs\kommerce\ActionHandler\Tag;

use inklabs\kommerce\Action\Tag\SetDefaultImageForTagCommand;
use inklabs\kommerce\Service\ImageServiceInterface;
use inklabs\kommerce\Service\TagServiceInterface;

final class SetDefaultImageForTagHandler
{
    /** @var TagServiceInterface */
    protected $tagService;

    /** @var ImageServiceInterface */
    private $imageService;

    public function __construct(
        TagServiceInterface $tagService,
        ImageServiceInterface $imageService
    ) {
        $this->tagService = $tagService;
        $this->imageService = $imageService;
    }

    public function handle(SetDefaultImageForTagCommand $command)
    {
        $tag = $this->tagService->findOneById($command->getTagId());
        $image = $this->imageService->findOneById($command->getImageId());

        $tag->setDefaultImage($image->getPath());

        $this->tagService->update($tag);
    }
}
