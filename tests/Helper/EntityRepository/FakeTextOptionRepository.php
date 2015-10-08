<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\TextOption;
use inklabs\kommerce\EntityRepository\TextOptionRepositoryInterface;

class FakeTextOptionRepository extends AbstractFakeRepository implements TextOptionRepositoryInterface
{
    public function __construct()
    {
        $this->setReturnValue(new TextOption);
    }

    public function find($id)
    {
        return $this->getReturnValue();
    }

    public function getAllTextOptionsByIds($optionIds, Pagination & $pagination = null)
    {
        return $this->getReturnValueAsArray();
    }
}
