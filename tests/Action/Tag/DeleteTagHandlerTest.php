<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\EntityRepository\EntityNotFoundException;
use inklabs\kommerce\tests\Action\Tag\AbstractTagHandlerTestCase;

class DeleteTagHandlerTest extends AbstractTagHandlerTestCase
{
    public function testHandle()
    {
        $tagId = 1;
        $this->fakeTagRepository->create(new Tag);

        $deleteTagHandler = new DeleteTagHandler($this->tagService);
        $deleteTagHandler->handle(new DeleteTagCommand($tagId));

        try {
            $this->fakeTagRepository->findOneById($tagId);
            $this->assertTrue(false, 'failure');
        } catch (EntityNotFoundException $e) {
            $this->assertTrue(true, 'success');
        }
    }
}
