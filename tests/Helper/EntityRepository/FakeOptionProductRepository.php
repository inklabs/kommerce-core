<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\Entity\OptionProduct;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\EntityRepository\OptionProductRepositoryInterface;

class FakeOptionProductRepository extends AbstractFakeRepository implements OptionProductRepositoryInterface
{
    public function __construct()
    {
        $this->setReturnValue(new OptionProduct);
    }

    public function find($id)
    {
        return $this->getReturnValue();
    }

    public function getAllOptionProductsByIds($optionValueIds, Pagination & $pagination = null)
    {
        return $this->getReturnValueAsArray();
    }
}
