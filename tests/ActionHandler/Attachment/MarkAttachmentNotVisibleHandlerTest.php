<?php
namespace inklabs\kommerce\ActionHandler\Attachment;

use inklabs\kommerce\Action\Attachment\MarkAttachmentNotVisibleCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class MarkAttachmentNotVisibleHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $attachmentService = $this->mockService->getAttachmentService();
        $attachmentService->shouldReceive('update')
            ->once();

        $command = new MarkAttachmentNotVisibleCommand(self::UUID_HEX);
        $handler = new MarkAttachmentNotVisibleHandler($attachmentService);
        $handler->handle($command);
    }
}
