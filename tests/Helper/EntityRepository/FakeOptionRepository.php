<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\EntityRepository\OptionRepositoryInterface;

class FakeOptionRepository extends AbstractFakeRepository implements OptionRepositoryInterface
{
    public function __construct()
    {
        $this->setReturnValue(new Option);
    }

    public function find($id)
    {
        return $this->getReturnValue();
    }

    public function getAllOptions($queryString = null, Pagination & $pagination = null)
    {
        return $this->getReturnValueAsArray();
    }

    public function getAllOptionsByIds(array $optionIds, Pagination & $pagination = null)
    {
        return $this->getReturnValueAsArray();
    }
}
