<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\EntityRepository\TagRepositoryInterface;

class DeleteTag
{
    /** @var TagRepositoryInterface */
    private $tagRepository;

    public function __construct(TagRepositoryInterface $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function execute(DeleteTagCommand $command)
    {
        $tag = $this->tagRepository->find($command->getTagId());
        $this->tagRepository->remove($tag);
    }
}
