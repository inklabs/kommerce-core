<?php
namespace inklabs\kommerce\ActionHandler\Image;

use inklabs\kommerce\Action\Image\CreateImageWithProductCommand;
use inklabs\kommerce\Service\ImageServiceInterface;

final class CreateImageWithProductHandler
{
    /** @var ImageServiceInterface */
    protected $imageService;

    public function __construct(ImageServiceInterface $imageService)
    {
        $this->imageService = $imageService;
    }

    public function handle(CreateImageWithProductCommand $command)
    {
        $this->imageService->createFromDTOWithProduct(
            $command->getProductId(),
            $command->getImageDTO()
        );
    }
}
