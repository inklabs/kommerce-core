<?php
namespace inklabs\kommerce\ActionHandler\Attachment;

use inklabs\kommerce\Action\Attachment\CreateAttachmentForOrderItemCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CreateAttachmentForOrderItemHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $uploadFileDTO = $this->dummyData->getUploadFileDTO();
        $orderItemId = 1;

        $attachmentService = $this->mockService->getAttachmentService();
        $attachmentService->shouldReceive('createAttachmentForOrderItem')
            ->with($uploadFileDTO, $orderItemId)
            ->once();

        $command = new CreateAttachmentForOrderItemCommand($uploadFileDTO, $orderItemId);
        $handler = new CreateAttachmentForOrderItemHandler($attachmentService);
        $handler->handle($command);
    }
}
