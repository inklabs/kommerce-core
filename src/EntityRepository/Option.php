<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

class Option extends AbstractEntityRepository implements OptionInterface
{
    public function getAllOptionsByIds($optionIds, Entity\Pagination & $pagination = null)
    {
        $qb = $this->getQueryBuilder();

        $options = $qb->select('Option')
            ->from('kommerce:Option', 'Option')
            ->where('Option.id IN (:optionIds)')
            ->setParameter('optionIds', $optionIds)
            ->paginate($pagination)
            ->getQuery()
            ->getResult();

        return $options;
    }
}
