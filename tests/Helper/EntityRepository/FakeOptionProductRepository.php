<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\OptionProduct;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\EntityRepository\OptionProductRepositoryInterface;

/**
 * @method OptionProduct findOneById($id)
 */
class FakeOptionProductRepository extends AbstractFakeRepository implements OptionProductRepositoryInterface
{
    public function __construct()
    {
        $this->setReturnValue(new OptionProduct(new Option, new Product));
    }

    public function getAllOptionProductsByIds($optionValueIds, Pagination & $pagination = null)
    {
        return $this->getReturnValueAsArray();
    }
}
