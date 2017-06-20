<?php
namespace inklabs\kommerce\Action\Attachment;

use inklabs\kommerce\Lib\Command\CommandInterface;
use inklabs\kommerce\Lib\Uuid;
use inklabs\kommerce\Lib\UuidInterface;

final class MarkAttachmentLockedCommand implements CommandInterface
{
    /** @var UuidInterface */
    private $attachmentId;

    public function __construct(string $attachmentId)
    {
        $this->attachmentId = Uuid::fromString($attachmentId);
    }

    public function getAttachmentId(): UuidInterface
    {
        return $this->attachmentId;
    }
}
