<?php
namespace inklabs\kommerce\ActionHandler\Tag;

use inklabs\kommerce\Action\Tag\AddTextOptionToTagCommand;
use inklabs\kommerce\EntityRepository\TagRepositoryInterface;
use inklabs\kommerce\EntityRepository\TextOptionRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class AddTextOptionToTagHandler implements CommandHandlerInterface
{
    /** @var AddTextOptionToTagCommand */
    private $command;

    /** @var TagRepositoryInterface */
    private $tagRepository;

    /** @var TextOptionRepositoryInterface */
    private $textOptionRepository;

    public function __construct(
        AddTextOptionToTagCommand $command,
        TagRepositoryInterface $tagRepository,
        TextOptionRepositoryInterface $textOptionRepository
    ) {
        $this->command = $command;
        $this->tagRepository = $tagRepository;
        $this->textOptionRepository = $textOptionRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $tag = $this->tagRepository->findOneById($this->command->getTagId());
        $textOption = $this->textOptionRepository->findOneById($this->command->getTextOptionId());

        $tag->addTextOption($textOption);

        $this->tagRepository->update($tag);
    }
}
