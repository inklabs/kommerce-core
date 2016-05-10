<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\OptionValue;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\EntityRepository\OptionValueRepositoryInterface;

/**
 * @method OptionValue findOneById($id)
 */
class FakeOptionValueRepository extends AbstractFakeRepository implements OptionValueRepositoryInterface
{
    public function __construct()
    {
        $this->setReturnValue(new OptionValue(new Option));
    }

    public function getAllOptionValuesByIds(array $optionValueIds, Pagination &$pagination = null)
    {
        return $this->getReturnValueAsArray();
    }
}
