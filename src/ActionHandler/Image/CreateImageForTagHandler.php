<?php
namespace inklabs\kommerce\ActionHandler\Image;

use inklabs\kommerce\Action\Image\CreateImageForTagCommand;
use inklabs\kommerce\Service\ImageServiceInterface;

final class CreateImageForTagHandler
{
    /** @var ImageServiceInterface */
    protected $imageService;

    public function __construct(ImageServiceInterface $imageService)
    {
        $this->imageService = $imageService;
    }

    public function handle(CreateImageForTagCommand $command)
    {
        $this->imageService->createImageForTag(
            $command->getUploadFileDTO(),
            $command->getTagId()
        );
    }
}
