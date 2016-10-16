<?php
namespace inklabs\kommerce\ActionHandler\Image;

use inklabs\kommerce\Action\Image\CreateImageForProductCommand;
use inklabs\kommerce\Service\ImageServiceInterface;

final class CreateImageForProductHandler
{
    /** @var ImageServiceInterface */
    protected $imageService;

    public function __construct(ImageServiceInterface $imageService)
    {
        $this->imageService = $imageService;
    }

    public function handle(CreateImageForProductCommand $command)
    {
        $this->imageService->createImageForProduct(
            $command->getUploadFileDTO(),
            $command->getProductId()
        );
    }
}
