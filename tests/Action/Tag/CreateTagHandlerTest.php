<?php
namespace inklabs\kommerce\Action\Tag;

use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\EntityDTO\TagDTO;
use inklabs\kommerce\tests\Action\Tag\AbstractTagHandlerTestCase;

class CreateTagHandlerTest extends AbstractTagHandlerTestCase
{
    /** @var TagDTO */
    protected $tagDTO;

    public function setUp()
    {
        parent::setUp();

        $this->tagDTO = new TagDTO;
        $this->tagDTO->name = 'Tag Name';
        $this->tagDTO->code = 'TAG-CODE';
        $this->tagDTO->description = 'Tag Description';
        $this->tagDTO->isActive = true;
        $this->tagDTO->isVisible = true;
        $this->tagDTO->sortOrder = 0;
    }

    public function testHandle()
    {
        $createTagHandler = new CreateTagHandler($this->tagService);
        $createTagHandler->handle(new CreateTagCommand($this->tagDTO));

        $this->assertTrue($this->fakeTagRepository->findOneById(1) instanceof Tag);
    }

    public function testHandleThroughCommandBus()
    {
        $this->setupEntityManager(['kommerce:Tag']);

        $this->getCommandBus()->execute(new CreateTagCommand($this->tagDTO));

        $this->assertTrue($this->getRepositoryFactory()->getTagRepository()->findOneById(1) instanceof Tag);
    }
}
