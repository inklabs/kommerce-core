<?php
namespace inklabs\kommerce\ActionHandler\Attachment;

use inklabs\kommerce\Action\Attachment\MarkAttachmentLockedCommand;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;
use inklabs\kommerce\Service\AttachmentServiceInterface;

class MarkAttachmentLockedHandler implements CommandHandlerInterface
{
    /** @var MarkAttachmentLockedCommand */
    private $command;

    /** @var AttachmentServiceInterface */
    private $attachmentService;

    public function __construct(
        MarkAttachmentLockedCommand $command,
        AttachmentServiceInterface $attachmentService
    ) {
        $this->command = $command;
        $this->attachmentService = $attachmentService;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $attachment = $this->attachmentService->getOneById(
            $this->command->getAttachmentId()
        );
        $attachment->setLocked();

        $this->attachmentService->update($attachment);
    }
}
