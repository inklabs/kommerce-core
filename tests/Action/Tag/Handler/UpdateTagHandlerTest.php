<?php
namespace inklabs\kommerce\Action\Tag\Handler;

use inklabs\kommerce\Action\Tag\UpdateTagCommand;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\EntityDTO\TagDTO;
use inklabs\kommerce\Service\TagServiceInterface;
use inklabs\kommerce\tests\Helper\DoctrineTestCase;
use Mockery;

class UpdateTagHandlerTest extends DoctrineTestCase
{
    /** @var TagDTO */
    protected $tagDTO;

    public function testHandle()
    {
        $tagService = Mockery::mock(TagServiceInterface::class);
        $tagService->shouldReceive('findOneById')
            ->andReturn(new Tag);
        $tagService->shouldReceive('update')
            ->once();
        /** @var TagServiceInterface $tagService */

        $command = new UpdateTagCommand(new TagDTO);
        $handler = new UpdateTagHandler($tagService);
        $handler->handle($command);
    }
}
