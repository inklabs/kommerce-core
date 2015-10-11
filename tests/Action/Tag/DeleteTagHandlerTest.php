<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\EntityRepository\EntityNotFoundException;
use inklabs\kommerce\tests\Action\Tag\AbstractTagHandlerTestCase;

class DeleteTagHandlerTest extends AbstractTagHandlerTestCase
{
    public function testExecute()
    {
        $tagId = 1;
        $this->tagRepository->create(new Tag);

        $deleteTagHandler = new DeleteTagHandler($this->tagService);
        $deleteTagHandler->handle(new DeleteTagCommand($tagId));

        try {
            $this->tagRepository->findOneById($tagId);
            $this->assertTrue(false, 'failure');
        } catch (EntityNotFoundException $e) {
            $this->assertTrue(true, 'success');
        }
    }
}
