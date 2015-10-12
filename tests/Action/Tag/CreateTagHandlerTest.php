<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\tests\Action\Tag\AbstractTagHandlerTestCase;

class CreateTagHandlerTest extends AbstractTagHandlerTestCase
{
    protected $tagPost = [
        'name' => 'Tag Name',
        'code' => 'TAG-CODE',
        'description' => 'Tag Description',
        'isActive' => true,
        'isVisible' => true,
        'sortOrder' => 0,
    ];

    public function testHandle()
    {
        $createTagHandler = new CreateTagHandler($this->tagService);
        $createTagHandler->handle(new CreateTagCommand($this->tagPost));

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

        $this->getCommandBus()->execute(new CreateTagCommand($this->tagPost));

        $this->assertTrue($this->getRepositoryFactory()->getTagRepository()->findOneById(1) instanceof Tag);
    }
}
