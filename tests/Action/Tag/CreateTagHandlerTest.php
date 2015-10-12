<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\tests\Action\Tag\AbstractTagHandlerTestCase;

class CreateTagHandlerTest extends AbstractTagHandlerTestCase
{
    public function testHandle()
    {
        $tag = $this->getDummyTag();

        $createTagHandler = new CreateTagHandler($this->tagService);
        $createTagHandler->handle(new CreateTagCommand($tag));

        $this->assertTrue($this->fakeTagRepository->findOneById(1) instanceof Tag);
    }

    public function testHandleThroughCommandBus()
    {
        $this->metaDataClassNames = [
            'kommerce:Image',
            'kommerce:Tag',
            'kommerce:Product',
            'kommerce:Option',
            'kommerce:TextOption',
        ];

        $this->setupEntityManager();
        $tag = $this->getDummyTag();

        $this->getCommandBus()->execute(new CreateTagCommand($tag));

        $this->assertSame(null, $tag->getId(), 'Tag should not be modified in the command');
        $this->assertTrue($this->getRepositoryFactory()->getTagRepository()->findOneById(1) instanceof Tag);
    }
}
