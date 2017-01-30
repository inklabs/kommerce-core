<?php
namespace inklabs\kommerce\ActionHandler\Tag;

use inklabs\kommerce\Action\Tag\RemoveImageFromTagCommand;
use inklabs\kommerce\EntityRepository\ImageRepositoryInterface;
use inklabs\kommerce\EntityRepository\TagRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class RemoveImageFromTagHandler implements CommandHandlerInterface
{
    /** @var RemoveImageFromTagCommand */
    private $command;

    /** @var ImageRepositoryInterface */
    private $imageRepository;

    /** @var TagRepositoryInterface */
    private $tagRepository;

    public function __construct(
        RemoveImageFromTagCommand $command,
        ImageRepositoryInterface $imageRepository,
        TagRepositoryInterface $tagRepository
    ) {
        $this->command = $command;
        $this->imageRepository = $imageRepository;
        $this->tagRepository = $tagRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $image = $this->imageRepository->findOneById($this->command->getImageId());
        $tag = $this->tagRepository->findOneById($this->command->getTagId());
        $tag->removeImage($image);

        $this->tagRepository->update($tag);

        if ($image->getProduct() === null) {
            $this->imageRepository->delete($image);
        }
    }
}
