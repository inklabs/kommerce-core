<?php
namespace inklabs\kommerce\Action\Tag\Handler;

use inklabs\kommerce\Action\Tag\DeleteTagCommand;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\Service\TagServiceInterface;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class DeleteTagHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $tagService = $this->getMockeryMock(TagServiceInterface::class);
        $tagService->shouldReceive('findOneById')
            ->andReturn(new Tag);
        $tagService->shouldReceive('delete')
            ->once();
        /** @var TagServiceInterface $tagService */

        $command = new DeleteTagCommand(1);
        $handler = new DeleteTagHandler($tagService);
        $handler->handle($command);
    }
}
