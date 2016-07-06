<?php
namespace inklabs\kommerce\ActionHandler\Attachment;

use inklabs\kommerce\Action\Attachment\MarkAttachmentUnlockedCommand;
use inklabs\kommerce\Service\AttachmentServiceInterface;

class MarkAttachmentUnlockedHandler
{
    /** @var AttachmentServiceInterface */
    private $attachmentService;

    public function __construct(AttachmentServiceInterface $attachmentService)
    {
        $this->attachmentService = $attachmentService;
    }

    public function handle(MarkAttachmentUnlockedCommand $command)
    {
        $attachment = $this->attachmentService->getOneById($command->getAttachmentId());
        $attachment->setUnlocked();

        $this->attachmentService->update($attachment);
    }
}
