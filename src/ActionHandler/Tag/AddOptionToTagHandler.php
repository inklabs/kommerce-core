<?php
namespace inklabs\kommerce\ActionHandler\Tag;

use inklabs\kommerce\Action\Tag\AddOptionToTagCommand;
use inklabs\kommerce\EntityRepository\OptionRepositoryInterface;
use inklabs\kommerce\EntityRepository\TagRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class AddOptionToTagHandler implements CommandHandlerInterface
{
    /** @var AddOptionToTagCommand */
    private $command;

    /** @var TagRepositoryInterface */
    protected $tagRepository;

    /** @var OptionRepositoryInterface */
    private $optionRepository;

    public function __construct(
        AddOptionToTagCommand $command,
        OptionRepositoryInterface $optionRepository,
        TagRepositoryInterface $tagRepository
    ) {
        $this->command = $command;
        $this->tagRepository = $tagRepository;
        $this->optionRepository = $optionRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $option = $this->optionRepository->findOneById($this->command->getOptionId());
        $tag = $this->tagRepository->findOneById($this->command->getTagId());

        $tag->addOption($option);

        $this->tagRepository->update($tag);
    }
}
