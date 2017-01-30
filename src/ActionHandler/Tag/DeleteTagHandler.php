<?php
namespace inklabs\kommerce\ActionHandler\Tag;

use inklabs\kommerce\Action\Tag\DeleteTagCommand;
use inklabs\kommerce\EntityRepository\TagRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class DeleteTagHandler implements CommandHandlerInterface
{
    /** @var DeleteTagCommand */
    private $command;

    /** @var TagRepositoryInterface */
    private $tagRepository;

    public function __construct(DeleteTagCommand $command, TagRepositoryInterface $tagRepository)
    {
        $this->command = $command;
        $this->tagRepository = $tagRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $tag = $this->tagRepository->findOneById($this->command->getTagId());
        $this->tagRepository->delete($tag);
    }
}
