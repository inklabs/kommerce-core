<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\Attachment;
use inklabs\kommerce\EntityDTO\AttachmentDTO;

class AttachmentDTOBuilder implements DTOBuilderInterface
{
    use IdDTOBuilderTrait, TimeDTOBuilderTrait;

    /** @var Attachment */
    protected $entity;

    /** @var AttachmentDTO */
    protected $entityDTO;

    /** @var DTOBuilderFactoryInterface */
    protected $dtoBuilderFactory;

    public function __construct(Attachment $attachment, DTOBuilderFactoryInterface $dtoBuilderFactory)
    {
        $this->entity = $attachment;
        $this->dtoBuilderFactory = $dtoBuilderFactory;

        $this->entityDTO = new AttachmentDTO;
        $this->setId();
        $this->setTime();
        $this->entityDTO->isVisible = $this->entity->isVisible();
        $this->entityDTO->isLocked  = $this->entity->isLocked();
        $this->entityDTO->uri       = $this->entity->getUri();
    }

    /**
     * @return static
     */
    public function withOrderItems()
    {
        foreach ($this->entity->getOrderItems() as $orderItem) {
            $this->entityDTO->orderItems[] = $this->dtoBuilderFactory
                ->getOrderItemDTOBuilder($orderItem)
                ->build();
        }

        return $this;
    }

    /**
     * @return static
     */
    public function withAllData()
    {
        return $this
            ->withOrderItems();
    }

    protected function preBuild()
    {
    }

    public function build()
    {
        $this->preBuild();
        unset($this->entity);
        return $this->entityDTO;
    }
}
