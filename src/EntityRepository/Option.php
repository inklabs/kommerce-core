<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

/**
 * @method Entity\Option find($id)
 */
class Option extends AbstractEntityRepository
{
    /**
     * @param int[] $optionIds
     * @param Entity\Pagination $pagination
     * @return Entity\Option[]
     */
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
