<?php
namespace inklabs\kommerce\tests\EntityRepository;

use inklabs\kommerce\EntityRepository\TaxRateInterface;
use inklabs\kommerce\Entity;
use inklabs\kommerce\tests\Helper;

class FakeTaxRate extends Helper\AbstractFake implements TaxRateInterface
{
    public function __construct()
    {
        $this->setReturnValue(new Entity\TaxRate);
    }

    public function find($id)
    {
        return $this->getReturnValue();
    }

    public function findAll()
    {
        return $this->getReturnValueAsArray();
    }

    public function findByZip5AndState($zip5 = null, $state = null)
    {
        return $this->getReturnValue();
    }
}
