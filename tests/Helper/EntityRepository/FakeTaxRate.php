<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\EntityRepository\TaxRateInterface;
use inklabs\kommerce\Entity;

class FakeTaxRate extends AbstractFake implements TaxRateInterface
{
    public function __construct()
    {
        $this->setReturnValue(new Entity\TaxRate);
    }

    public function save(Entity\TaxRate & $taxRate)
    {
    }

    public function create(Entity\TaxRate & $taxRate)
    {
    }

    public function remove(Entity\TaxRate & $taxRate)
    {
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
