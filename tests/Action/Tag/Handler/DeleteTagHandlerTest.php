<?php
namespace inklabs\kommerce\Action\Tag\Handler;

use inklabs\kommerce\Action\Tag\DeleteTagCommand;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\Service\TagServiceInterface;
use inklabs\kommerce\tests\Helper\DoctrineTestCase;
use Mockery;

class DeleteTagHandlerTest extends DoctrineTestCase
{
    public function testHandle()
    {
        $tagService = Mockery::mock(TagServiceInterface::class);
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
