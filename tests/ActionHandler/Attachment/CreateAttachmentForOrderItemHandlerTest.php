<?php
namespace inklabs\kommerce\ActionHandler\Attachment;

use inklabs\kommerce\Action\Attachment\CreateAttachmentForOrderItemCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CreateAttachmentForOrderItemHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $uploadFileDTO = $this->dummyData->getUploadFileDTO();
        $orderItem = $this->dummyData->getOrderItem();

        $attachmentService = $this->mockService->getAttachmentService();
        $attachmentService->shouldReceive('createAttachmentForOrderItem')
            ->with($uploadFileDTO, $orderItem->getId())
            ->once();

        $command = new CreateAttachmentForOrderItemCommand($uploadFileDTO, $orderItem->getId());
        $handler = new CreateAttachmentForOrderItemHandler($attachmentService);
        $handler->handle($command);
    }
}
