<?php
namespace inklabs\kommerce\ActionHandler\Tag;

use inklabs\kommerce\Action\Tag\UnsetDefaultImageForTagCommand;
use inklabs\kommerce\EntityRepository\TagRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class UnsetDefaultImageForTagHandler implements CommandHandlerInterface
{
    /** @var UnsetDefaultImageForTagCommand */
    private $command;

    /** @var TagRepositoryInterface */
    protected $tagRepository;

    public function __construct(UnsetDefaultImageForTagCommand $command, TagRepositoryInterface $tagRepository)
    {
        $this->command = $command;
        $this->tagRepository = $tagRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext): void
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $tag = $this->tagRepository->findOneById($this->command->getTagId());
        $tag->setDefaultImage(null);

        $this->tagRepository->update($tag);
    }
}
