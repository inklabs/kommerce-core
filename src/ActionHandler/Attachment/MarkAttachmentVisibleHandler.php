<?php
namespace inklabs\kommerce\ActionHandler\Attachment;

use inklabs\kommerce\Action\Attachment\MarkAttachmentVisibleCommand;
use inklabs\kommerce\EntityRepository\AttachmentRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

final class MarkAttachmentVisibleHandler implements CommandHandlerInterface
{
    /** @var MarkAttachmentVisibleCommand */
    private $command;

    /** @var AttachmentRepositoryInterface */
    private $attachmentRepository;

    public function __construct(
        MarkAttachmentVisibleCommand $command,
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
        $attachment->setVisible();

        $this->attachmentRepository->update($attachment);
    }
}
