<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\Entity\OptionValue;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\EntityRepository\OptionValueRepositoryInterface;

class FakeOptionValueRepository extends AbstractFakeRepository implements OptionValueRepositoryInterface
{
    public function __construct()
    {
        $this->setReturnValue(new OptionValue);
    }

    public function find($id)
    {
        return $this->getReturnValue();
    }

    public function getAllOptionValuesByIds(array $optionValueIds, Pagination &$pagination = null)
    {
        return $this->getReturnValueAsArray();
    }
}
