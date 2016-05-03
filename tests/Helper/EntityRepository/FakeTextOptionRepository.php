<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\TextOption;
use inklabs\kommerce\EntityRepository\TextOptionRepositoryInterface;

/**
 * @method TextOption findOneById($id)
 */
class FakeTextOptionRepository extends FakeRepository implements TextOptionRepositoryInterface
{
    public function __construct()
    {
        $this->setReturnValue(new TextOption);
    }

    public function getAllTextOptionsByIds($optionIds, Pagination & $pagination = null)
    {
        return $this->getReturnValueAsArray();
    }
}
