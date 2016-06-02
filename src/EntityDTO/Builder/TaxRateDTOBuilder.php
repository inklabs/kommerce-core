<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\EntityDTO\TaxRateDTO;

class TaxRateDTOBuilder implements DTOBuilderInterface
{
    use IdDTOBuilderTrait, TimeDTOBuilderTrait;

    /** @var TaxRate */
    protected $entity;

    /** @var TaxRateDTO */
    protected $entityDTO;

    public function __construct(TaxRate $taxRate)
    {
        $this->entity = $taxRate;

        $this->entityDTO = new TaxRateDTO;
        $this->setId();
        $this->setTime();
        $this->entityDTO->state           = $this->entity->getState();
        $this->entityDTO->zip5            = $this->entity->getZip5();
        $this->entityDTO->zip5From        = $this->entity->getZip5From();
        $this->entityDTO->zip5To          = $this->entity->getZip5To();
        $this->entityDTO->rate            = $this->entity->getRate();
        $this->entityDTO->applyToShipping = $this->entity->getApplyToShipping();
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
