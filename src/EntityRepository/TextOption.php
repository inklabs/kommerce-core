<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

/**
 * @method Entity\TextOption find($id)
 */
class TextOption extends AbstractEntityRepository
{
    /**
     * @param int[] $optionIds
     * @param Entity\Pagination $pagination
     * @return Entity\Option[]
     */
    public function getAllOptionsByIds($optionIds, Entity\Pagination & $pagination = null)
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
