<?php
namespace inklabs\kommerce\ActionHandler\Attachment;

use inklabs\kommerce\Action\Attachment\MarkAttachmentNotVisibleCommand;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;
use inklabs\kommerce\Service\AttachmentServiceInterface;

class MarkAttachmentNotVisibleHandler implements CommandHandlerInterface
{
    /** @var MarkAttachmentNotVisibleCommand */
    private $command;

    /** @var AttachmentServiceInterface */
    private $attachmentService;

    public function __construct(
        MarkAttachmentNotVisibleCommand $command,
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
        $attachment->setNotVisible();

        $this->attachmentService->update($attachment);
    }
}
