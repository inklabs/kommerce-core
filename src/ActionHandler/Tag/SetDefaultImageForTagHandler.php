<?php
namespace inklabs\kommerce\ActionHandler\Tag;

use inklabs\kommerce\Action\Tag\SetDefaultImageForTagCommand;
use inklabs\kommerce\EntityRepository\ImageRepositoryInterface;
use inklabs\kommerce\EntityRepository\TagRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class SetDefaultImageForTagHandler implements CommandHandlerInterface
{
    /** @var SetDefaultImageForTagCommand */
    private $command;

    /** @var TagRepositoryInterface */
    protected $tagRepository;

    /** @var ImageRepositoryInterface */
    private $imageRepository;

    public function __construct(
        SetDefaultImageForTagCommand $command,
        TagRepositoryInterface $tagRepository,
        ImageRepositoryInterface $imageRepository
    ) {
        $this->command = $command;
        $this->tagRepository = $tagRepository;
        $this->imageRepository = $imageRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $image = $this->imageRepository->findOneById($this->command->getImageId());
        $tag = $this->tagRepository->findOneById($this->command->getTagId());
        $tag->setDefaultImage($image->getPath());

        $this->tagRepository->update($tag);
    }
}
