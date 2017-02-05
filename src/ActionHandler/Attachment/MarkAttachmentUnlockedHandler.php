<?php
namespace inklabs\kommerce\ActionHandler\Attachment;

use inklabs\kommerce\Action\Attachment\MarkAttachmentUnlockedCommand;
use inklabs\kommerce\EntityRepository\AttachmentRepositoryInterface;
use inklabs\kommerce\Lib\Authorization\AuthorizationContextInterface;
use inklabs\kommerce\Lib\Command\CommandHandlerInterface;

class MarkAttachmentUnlockedHandler implements CommandHandlerInterface
{
    /** @var MarkAttachmentUnlockedCommand */
    private $command;

    /** @var AttachmentRepositoryInterface */
    private $attachmentRepository;

    public function __construct(
        MarkAttachmentUnlockedCommand $command,
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
        $attachment->setUnlocked();

        $this->attachmentRepository->update($attachment);
    }
}
