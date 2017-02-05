<?php
namespace inklabs\kommerce\ActionHandler\Attachment;

use inklabs\kommerce\Action\Attachment\DeleteAttachmentCommand;
use inklabs\kommerce\EntityRepository\AttachmentRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

class DeleteAttachmentHandler implements CommandHandlerInterface
{
    /** @var DeleteAttachmentCommand */
    private $command;

    /** @var AttachmentRepositoryInterface */
    private $attachmentRepository;

    public function __construct(
        DeleteAttachmentCommand $command,
        AttachmentRepositoryInterface $attachmentRepository
    ) {
        $this->command = $command;
        $this->attachmentRepository = $attachmentRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext)
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $attachment = $this->attachmentRepository->findOneById(
            $this->command->getAttachmentId()
        );
        $this->attachmentRepository->delete($attachment);
    }
}
