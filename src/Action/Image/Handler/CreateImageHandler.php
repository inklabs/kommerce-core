<?php
namespace inklabs\kommerce\Action\Image\Handler;

use inklabs\kommerce\Action\Image\CreateImageCommand;
use inklabs\kommerce\Service\ImageServiceInterface;

final class CreateImageHandler
{
    /** @var ImageServiceInterface */
    protected $imageService;

    public function __construct(ImageServiceInterface $imageService)
    {
        $this->imageService = $imageService;
    }

    public function handle(CreateImageCommand $command)
    {
        $this->imageService->createFromDTOWithTag(
            $command->getImageDTO(),
            $command->getTagId()
        );
    }
}
