<?php
namespace inklabs\kommerce\ActionHandler\Attachment;

use inklabs\kommerce\Action\Attachment\DeleteAttachmentCommand;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;
use inklabs\kommerce\Service\AttachmentServiceInterface;

class DeleteAttachmentHandler implements CommandHandlerInterface
{
    /** @var DeleteAttachmentCommand */
    private $command;

    /** @var AttachmentServiceInterface */
    private $attachmentService;

    public function __construct(
        DeleteAttachmentCommand $command,
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
        $this->attachmentService->delete($attachment);
    }
}
