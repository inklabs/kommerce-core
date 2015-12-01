<?php
namespace inklabs\kommerce\Action\Tag\Handler;

use inklabs\kommerce\Action\Tag\CreateTagCommand;
use inklabs\kommerce\EntityDTO\TagDTO;
use inklabs\kommerce\Service\TagServiceInterface;
use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class CreateTagHandlerTest extends DoctrineTestCase
{
    public function testHandle()
    {
        $tagService = $this->getMockeryMock(TagServiceInterface::class);
        $tagService->shouldReceive('create')
            ->once();
        /** @var TagServiceInterface $tagService */

        $command = new CreateTagCommand(new TagDTO);
        $handler = new CreateTagHandler($tagService);
        $handler->handle($command);
    }
}
