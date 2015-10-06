<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\Entity\EntityValidator;
use inklabs\kommerce\EntityRepository\TagRepositoryInterface;

class CreateTag
{
    /** @var TagRepositoryInterface */
    private $tagRepository;

    public function __construct(TagRepositoryInterface $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function execute(CreateTagCommand $command)
    {
        $tag = $command->getTag();

        $validation = new EntityValidator;
        $validation->throwValidationErrors($tag);

        $this->tagRepository->create($tag);
    }
}
