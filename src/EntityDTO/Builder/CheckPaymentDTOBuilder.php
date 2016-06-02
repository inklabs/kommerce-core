<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\CheckPayment;
use inklabs\kommerce\EntityDTO\AbstractPaymentDTO;
use inklabs\kommerce\EntityDTO\CheckPaymentDTO;

/**
 * @method CheckPaymentDTO build()
 */
class CheckPaymentDTOBuilder extends AbstractPaymentDTOBuilder
{
    /** @var CheckPayment */
    protected $entity;

    /** @var CheckPaymentDTO */
    protected $entityDTO;

    protected function getEntityDTO()
    {
        return new CheckPaymentDTO();
    }

    protected function preBuild()
    {
        $this->entityDTO->checkNumber = $this->entity->getCheckNumber();
        $this->entityDTO->memo = $this->entity->getMemo();
        $this->entityDTO->checkDate = $this->entity->getCHeckDate();
    }
}
