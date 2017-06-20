<?php
namespace inklabs\kommerce\ActionHandler\Attachment;

use inklabs\kommerce\Action\Attachment\MarkAttachmentLockedCommand;
use inklabs\kommerce\EntityRepository\AttachmentRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class MarkAttachmentLockedHandler implements CommandHandlerInterface
{
    /** @var MarkAttachmentLockedCommand */
    private $command;

    /** @var AttachmentRepositoryInterface */
    private $attachmentRepository;

    public function __construct(
        MarkAttachmentLockedCommand $command,
        AttachmentRepositoryInterface $attachmentRepository
    ) {
        $this->command = $command;
        $this->attachmentRepository = $attachmentRepository;
    }

    public function verifyAuthorization(AuthorizationContextInterface $authorizationContext): void
    {
        $authorizationContext->verifyIsAdmin();
    }

    public function handle()
    {
        $attachment = $this->attachmentRepository->findOneById(
            $this->command->getAttachmentId()
        );
        $attachment->setLocked();

        $this->attachmentRepository->update($attachment);
    }
}
