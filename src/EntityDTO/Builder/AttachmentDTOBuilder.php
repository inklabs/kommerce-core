<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\Attachment;
use inklabs\kommerce\EntityDTO\AttachmentDTO;

class AttachmentDTOBuilder
{
    /** @var Attachment */
    protected $attachment;

    /** @var AttachmentDTO */
    protected $attachmentDTO;

    public function __construct(Attachment $attachment)
    {
        $this->attachment = $attachment;

        $this->attachmentDTO = new AttachmentDTO;
        $this->attachmentDTO->id        = $this->attachment->getId();
        $this->attachmentDTO->isVisible = $this->attachment->isVisible();
        $this->attachmentDTO->isLocked  = $this->attachment->isLocked();
        $this->attachmentDTO->uri       = $this->attachment->getUri();
        $this->attachmentDTO->created   = $this->attachment->getCreated();
        $this->attachmentDTO->updated   = $this->attachment->getUpdated();
    }

    public function withOrderItems()
    {
        foreach ($this->attachment->getOrderItems() as $orderItem) {
            $this->attachmentDTO->orderItems[] = $orderItem->getDTOBuilder()
                ->build();
        }

        return $this;
    }

    public function withAllData()
    {
        return $this
            ->withOrderItems();
    }

    public function build()
    {
        return $this->attachmentDTO;
    }
}
