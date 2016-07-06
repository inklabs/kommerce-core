<?php
namespace inklabs\kommerce\ActionHandler\Attachment;

use inklabs\kommerce\Action\Attachment\MarkAttachmentLockedCommand;
use inklabs\kommerce\Service\AttachmentServiceInterface;

class MarkAttachmentLockedHandler
{
    /** @var AttachmentServiceInterface */
    private $attachmentService;

    public function __construct(AttachmentServiceInterface $attachmentService)
    {
        $this->attachmentService = $attachmentService;
    }

    public function handle(MarkAttachmentLockedCommand $command)
    {
        $attachment = $this->attachmentService->getOneById($command->getAttachmentId());
        $attachment->setLocked();

        $this->attachmentService->update($attachment);
    }
}
