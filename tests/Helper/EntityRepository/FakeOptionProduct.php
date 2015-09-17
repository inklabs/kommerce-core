<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\EntityRepository\OptionProductRepositoryInterface;
use inklabs\kommerce\Entity;

class FakeRepositoryOptionProduct extends AbstractFakeRepository implements OptionProductRepositoryInterface
{
    public function __construct()
    {
        $this->setReturnValue(new Entity\OptionProduct);
    }

    public function find($id)
    {
        return $this->getReturnValue();
    }

    public function getAllOptionProductsByIds($optionValueIds, Entity\Pagination &$pagination = null)
    {
        return $this->getReturnValueAsArray();
    }

    public function create(Entity\OptionProduct & $optionProduct)
    {
    }

    public function save(Entity\OptionProduct & $optionProduct)
    {
    }

    public function remove(Entity\OptionProduct & $optionProduct)
    {
    }
}
