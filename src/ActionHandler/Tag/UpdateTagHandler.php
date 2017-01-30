<?php
namespace inklabs\kommerce\ActionHandler\Tag;

use inklabs\kommerce\Action\Tag\UpdateTagCommand;
use inklabs\kommerce\EntityDTO\Builder\TagDTOBuilder;
use inklabs\kommerce\EntityRepository\TagRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class UpdateTagHandler implements CommandHandlerInterface
{
    /** @var UpdateTagCommand */
    private $command;

    /** @var TagRepositoryInterface */
    protected $tagRepository;

    public function __construct(UpdateTagCommand $command, TagRepositoryInterface $tagRepository)
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
        $tagDTO = $this->command->getTagDTO();
        $tag = $this->tagRepository->findOneById($tagDTO->id);
        TagDTOBuilder::setFromDTO($tag, $tagDTO);

        $this->tagRepository->update($tag);
    }
}
