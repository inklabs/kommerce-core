<?php
namespace inklabs\kommerce\ActionHandler\Attachment;

use inklabs\kommerce\Action\Attachment\MarkAttachmentVisibleCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class MarkAttachmentVisibleHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $attachmentService = $this->mockService->getAttachmentService();
        $attachmentService->shouldReceive('update')
            ->once();

        $command = new MarkAttachmentVisibleCommand(self::UUID_HEX);
        $handler = new MarkAttachmentVisibleHandler($attachmentService);
        $handler->handle($command);
    }
}
