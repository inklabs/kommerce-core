<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\AbstractPayment;
use inklabs\kommerce\EntityDTO\AbstractPaymentDTO;
use inklabs\kommerce\Exception\InvalidArgumentException;

abstract class AbstractPaymentDTOBuilder implements DTOBuilderInterface
{
    use IdDTOBuilderTrait, TimeDTOBuilderTrait;

    /** @var AbstractPayment */
    protected $entity;

    /** @var AbstractPaymentDTO */
    protected $entityDTO;

    /**
     * @return AbstractPaymentDTO
     */
    abstract protected function getEntityDTO();

    public function __construct(AbstractPayment $payment)
    {
        $this->entity = $payment;

        $this->entityDTO = $this->getEntityDTO();
        $this->setId();
        $this->setTime();
        $this->entityDTO->amount  = $this->entity->getAmount();
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
