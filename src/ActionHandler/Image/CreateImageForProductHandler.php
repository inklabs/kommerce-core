<?php
namespace inklabs\kommerce\ActionHandler\Image;

use inklabs\kommerce\Action\Image\CreateImageForProductCommand;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;
use inklabs\kommerce\Service\ImageServiceInterface;

final class CreateImageForProductHandler implements CommandHandlerInterface
{
    /** @var CreateImageForProductCommand */
    private $command;

    /** @var ImageServiceInterface */
    protected $imageService;

    public function __construct(
        CreateImageForProductCommand $command,
        ImageServiceInterface $imageService
    ) {
        $this->command = $command;
        $this->imageService = $imageService;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext): void
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $this->imageService->createImageForProduct(
            $this->command->getUploadFileDTO(),
            $this->command->getProductId()
        );
    }
}
