<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\Entity\EntityValidator;
use inklabs\kommerce\EntityRepository\TagRepositoryInterface;

class EditTag
{
    /** @var TagRepositoryInterface */
    private $tagRepository;

    public function __construct(TagRepositoryInterface $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function execute(EditTagCommand $command)
    {
        $tag = $command->getTag();

        $validation = new EntityValidator;
        $validation->throwValidationErrors($tag);

        $this->tagRepository->save($tag);
    }
}
