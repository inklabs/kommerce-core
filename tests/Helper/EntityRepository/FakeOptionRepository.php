<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\EntityRepository\OptionRepositoryInterface;

/**
 * @method Option findOneById($id)
 */
class FakeOptionRepository extends AbstractFakeRepository implements OptionRepositoryInterface
{
    protected $entityName = 'Option';

    public function getAllOptions($queryString = null, Pagination & $pagination = null)
    {
        return $this->entities;
    }

    public function getAllOptionsByIds(array $optionIds, Pagination & $pagination = null)
    {
        return $this->entities;
    }
}
