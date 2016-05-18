<?php
namespace inklabs\kommerce\ActionHandler\Attachment;

use inklabs\kommerce\Action\Attachment\CreateAttachmentForOrderItemCommand;
use inklabs\kommerce\Service\AttachmentServiceInterface;

class CreateAttachmentForOrderItemHandler
{
    /** @var AttachmentServiceInterface */
    private $attachmentService;

    public function __construct(AttachmentServiceInterface $attachmentService)
    {
        $this->attachmentService = $attachmentService;
    }

    public function handle(CreateAttachmentForOrderItemCommand $command)
    {
        $this->attachmentService->createAttachmentForOrderItem(
            $command->getUploadFileDTO(),
            $command->getOrderItemId()
        );
    }
}
