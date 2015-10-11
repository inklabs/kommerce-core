<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\tests\Action\Tag\AbstractTagHandlerTestCase;

class CreateTagHandlerTest extends AbstractTagHandlerTestCase
{
    public function testDispatch()
    {
        $tag = $this->getDummyTag();

        $createTagHandler = new CreateTagHandler($this->tagService);
        $createTagHandler->handle(new CreateTagCommand($tag));

        $this->assertTrue($this->tagRepository->findOneById(1) instanceof Tag);
    }
}
