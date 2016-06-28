<?php
namespace inklabs\kommerce\ActionHandler\Attachment;

use inklabs\kommerce\Action\Attachment\DeleteAttachmentCommand;
use inklabs\kommerce\Service\AttachmentServiceInterface;

class DeleteAttachmentHandler
{
    /** @var AttachmentServiceInterface */
    private $attachmentService;

    public function __construct(AttachmentServiceInterface $attachmentService)
    {
        $this->attachmentService = $attachmentService;
    }

    public function handle(DeleteAttachmentCommand $command)
    {
        $this->attachmentService->delete(
            $command->getAttachmentId()
        );
    }
}
