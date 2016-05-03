<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\EntityRepository\TaxRateRepositoryInterface;

/**
 * @method TaxRate findOneById($id)
 */
class FakeTaxRateRepository extends FakeRepository implements TaxRateRepositoryInterface
{
    public function __construct()
    {
        $this->setReturnValue(new TaxRate);
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
