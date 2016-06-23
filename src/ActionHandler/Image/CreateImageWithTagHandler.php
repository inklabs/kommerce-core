<?php
namespace inklabs\kommerce\ActionHandler\Image;

use inklabs\kommerce\Action\Image\CreateImageWithTagCommand;
use inklabs\kommerce\Service\ImageServiceInterface;

final class CreateImageWithTagHandler
{
    /** @var ImageServiceInterface */
    protected $imageService;

    public function __construct(ImageServiceInterface $imageService)
    {
        $this->imageService = $imageService;
    }

    public function handle(CreateImageWithTagCommand $command)
    {
        $this->imageService->createFromDTOWithTag(
            $command->getImageDTO(),
            $command->getTagId()
        );
    }
}
