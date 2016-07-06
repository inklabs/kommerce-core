<?php
namespace inklabs\kommerce\ActionHandler\Attachment;

use inklabs\kommerce\Action\Attachment\MarkAttachmentNotVisibleCommand;
use inklabs\kommerce\Service\AttachmentServiceInterface;

class MarkAttachmentNotVisibleHandler
{
    /** @var AttachmentServiceInterface */
    private $attachmentService;

    public function __construct(AttachmentServiceInterface $attachmentService)
    {
        $this->attachmentService = $attachmentService;
    }

    public function handle(MarkAttachmentNotVisibleCommand $command)
    {
        $attachment = $this->attachmentService->getOneById($command->getAttachmentId());
        $attachment->setNotVisible();

        $this->attachmentService->update($attachment);
    }
}
