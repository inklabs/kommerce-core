<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\EntityDTO\TaxRateDTO;

class TaxRateDTOBuilder
{
    /** @var TaxRate */
    protected $raxRate;

    /** @var TaxRateDTO */
    protected $taxRateDTO;

    public function __construct(TaxRate $taxRate)
    {
        $this->taxRate = $taxRate;

        $this->taxRateDTO = new TaxRateDTO;
        $this->taxRateDTO->id              = $this->taxRate->getId();
        $this->taxRateDTO->state           = $this->taxRate->getState();
        $this->taxRateDTO->zip5            = $this->taxRate->getZip5();
        $this->taxRateDTO->zip5From        = $this->taxRate->getZip5From();
        $this->taxRateDTO->zip5To          = $this->taxRate->getZip5To();
        $this->taxRateDTO->rate            = $this->taxRate->getRate();
        $this->taxRateDTO->applyToShipping = $this->taxRate->getApplyToShipping();
        $this->taxRateDTO->created         = $this->taxRate->getCreated();
        $this->taxRateDTO->updated         = $this->taxRate->getUpdated();
    }

    public function build()
    {
        return $this->taxRateDTO;
    }
}
