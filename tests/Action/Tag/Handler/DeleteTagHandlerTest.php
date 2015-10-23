<?php
namespace inklabs\kommerce\Action\Tag\Handler;

use inklabs\kommerce\Action\Tag\DeleteTagCommand;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\EntityRepository\EntityNotFoundException;
use inklabs\kommerce\tests\Action\Tag\Handler\AbstractTagHandlerTestCase;

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
            $this->fail();
        } catch (EntityNotFoundException $e) {
            $this->assertTrue(true, 'success');
        }
    }
}
