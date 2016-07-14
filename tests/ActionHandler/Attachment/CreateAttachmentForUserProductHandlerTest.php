<?php
namespace inklabs\kommerce\ActionHandler\Attachment;

use inklabs\kommerce\Action\Attachment\CreateAttachmentForUserProductCommand;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class CreateAttachmentForUserProductHandlerTest extends ActionTestCase
{
    public function testHandle()
    {
        $uploadFileDTO = $this->dummyData->getUploadFileDTO();
        $user = $this->dummyData->getUser();
        $product = $this->dummyData->getProduct();

        $attachmentService = $this->mockService->getAttachmentService();
        $attachmentService->shouldReceive('createAttachmentForUserProduct')
            ->with($uploadFileDTO, $user->getId(), $product->getId())
            ->once();

        $command = new CreateAttachmentForUserProductCommand(
            $uploadFileDTO,
            $user->getId()->getHex(),
            $product->getId()->getHex()
        );

        $handler = new CreateAttachmentForUserProductHandler($attachmentService);
        $handler->handle($command);
    }
}
