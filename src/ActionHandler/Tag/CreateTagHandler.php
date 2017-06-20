<?php
namespace inklabs\kommerce\ActionHandler\Tag;

use inklabs\kommerce\Action\Tag\CreateTagCommand;
use inklabs\kommerce\EntityDTO\Builder\TagDTOBuilder;
use inklabs\kommerce\EntityRepository\TagRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class CreateTagHandler implements CommandHandlerInterface
{
    /** @var CreateTagCommand */
    private $command;

    /** @var TagRepositoryInterface */
    protected $tagRepository;

    public function __construct(CreateTagCommand $command, TagRepositoryInterface $tagRepository)
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
        $tag = TagDTOBuilder::createFromDTO(
            $this->command->getTagId(),
            $this->command->getTagDTO()
        );

        $this->tagRepository->create($tag);
    }
}
