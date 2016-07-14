<?php
namespace inklabs\kommerce\ActionHandler\Attachment;

use inklabs\kommerce\Action\Attachment\CreateAttachmentForUserProductCommand;
use inklabs\kommerce\Service\AttachmentServiceInterface;

class CreateAttachmentForUserProductHandler
{
    /** @var AttachmentServiceInterface */
    private $attachmentService;

    public function __construct(AttachmentServiceInterface $attachmentService)
    {
        $this->attachmentService = $attachmentService;
    }

    public function handle(CreateAttachmentForUserProductCommand $command)
    {
        $this->attachmentService->createAttachmentForUserProduct(
            $command->getUploadFileDTO(),
            $command->getUserId(),
            $command->getProductId()
        );
    }
}
