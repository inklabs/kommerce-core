<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

/**
 * @method Entity\OptionType\AbstractOptionType find($id)
 */
class OptionType extends AbstractEntityRepository
{
    /**
     * @param int[] $optionIds
     * @param Entity\Pagination $pagination
     * @return Entity\OptionType\AbstractOptionType[]
     */
    public function getAllOptionsByIds($optionIds, Entity\Pagination & $pagination = null)
    {
        $qb = $this->getQueryBuilder();

        $options = $qb->select('OptionType')
            ->from('kommerce:OptionType\AbstractOptionType', 'OptionType')
            ->where('OptionType.id IN (:optionIds)')
            ->setParameter('optionIds', $optionIds)
            ->paginate($pagination)
            ->getQuery()
            ->getResult();

        return $options;
    }
}
