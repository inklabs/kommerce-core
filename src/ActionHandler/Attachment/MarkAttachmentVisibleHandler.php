<?php
namespace inklabs\kommerce\ActionHandler\Attachment;

use inklabs\kommerce\Action\Attachment\MarkAttachmentVisibleCommand;
use inklabs\kommerce\Service\AttachmentServiceInterface;

class MarkAttachmentVisibleHandler
{
    /** @var AttachmentServiceInterface */
    private $attachmentService;

    public function __construct(AttachmentServiceInterface $attachmentService)
    {
        $this->attachmentService = $attachmentService;
    }

    public function handle(MarkAttachmentVisibleCommand $command)
    {
        $attachment = $this->attachmentService->getOneById($command->getAttachmentId());
        $attachment->setVisible();

        $this->attachmentService->update($attachment);
    }
}
