<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;

class TaxRate
{
    public $id;
    public $state;
    public $zip5;
    public $zip5From;
    public $zip5To;
    public $rate;
    public $applyToShipping;
    public $created;
    public $updated;

    public function __construct(Entity\TaxRate $taxRate)
    {
        $this->id              = $taxRate->getId();
        $this->state           = $taxRate->getState();
        $this->zip5            = $taxRate->getZip5();
        $this->zip5From        = $taxRate->getZip5From();
        $this->zip5To          = $taxRate->getZip5To();
        $this->rate            = $taxRate->getRate();
        $this->applyToShipping = $taxRate->getApplyToShipping();
        $this->created         = $taxRate->getCreated();
        $this->updated         = $taxRate->getUpdated();
    }
}
