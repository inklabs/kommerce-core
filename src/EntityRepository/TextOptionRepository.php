<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\TextOption;

class TextOptionRepository extends AbstractRepository implements TextOptionRepositoryInterface
{
    public function getAllTextOptionsByIds($optionIds, Pagination & $pagination = null)
    {
        return $this->getQueryBuilder()
            ->select('TextOption')
            ->from(TextOption::class, 'TextOption')
            ->where('TextOption.id IN (:optionIds)')
            ->setIdParameter('optionIds', $optionIds)
            ->paginate($pagination)
            ->getQuery()
            ->getResult();
    }
}
