<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\Entity\OptionProduct;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\EntityRepository\OptionProductRepositoryInterface;

/**
 * @method OptionProduct findOneById($id)
 */
class FakeOptionProductRepository extends FakeRepository implements OptionProductRepositoryInterface
{
    public function __construct()
    {
        $this->setReturnValue(new OptionProduct);
    }

    public function getAllOptionProductsByIds($optionValueIds, Pagination & $pagination = null)
    {
        return $this->getReturnValueAsArray();
    }
}
