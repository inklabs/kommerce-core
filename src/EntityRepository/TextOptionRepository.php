<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Pagination;

class TextOptionRepository extends AbstractRepository implements TextOptionRepositoryInterface
{
    public function getAllTextOptionsByIds($optionIds, Pagination & $pagination = null)
    {
        $qb = $this->getQueryBuilder();

        $options = $qb->select('TextOption')
            ->from('kommerce:TextOption', 'TextOption')
            ->where('TextOption.id IN (:optionIds)')
            ->setParameter('optionIds', $optionIds)
            ->paginate($pagination)
            ->getQuery()
            ->getResult();

        return $options;
    }
}
