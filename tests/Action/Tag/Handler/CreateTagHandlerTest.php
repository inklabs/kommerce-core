<?php
namespace inklabs\kommerce\Action\Tag\Handler;

use inklabs\kommerce\Action\Tag\CreateTagCommand;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\EntityDTO\TagDTO;
use inklabs\kommerce\tests\Action\Tag\Handler\AbstractTagHandlerTestCase;

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
}
