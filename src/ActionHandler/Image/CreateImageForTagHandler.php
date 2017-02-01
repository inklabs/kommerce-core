<?php
namespace inklabs\kommerce\ActionHandler\Image;

use inklabs\kommerce\Action\Image\CreateImageForTagCommand;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;
use inklabs\kommerce\Service\ImageServiceInterface;

final class CreateImageForTagHandler implements CommandHandlerInterface
{
    /** @var CreateImageForTagCommand */
    private $command;

    /** @var ImageServiceInterface */
    protected $imageService;

    public function __construct(CreateImageForTagCommand $command, ImageServiceInterface $imageService)
    {
        $this->command = $command;
        $this->imageService = $imageService;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $this->imageService->createImageForTag(
            $this->command->getUploadFileDTO(),
            $this->command->getTagId()
        );
    }
}
