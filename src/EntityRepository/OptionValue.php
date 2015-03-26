<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Doctrine\ORM\EntityRepository;
use inklabs\kommerce\Entity as Entity;

/**
 * @method Entity\OptionValue find($id)
 */
class OptionValue extends EntityRepository
{
    /**
     * @return Entity\OptionValue[]
     */
    public function getAllOptionValuesByIds($optionValueIds, Entity\Pagination & $pagination = null)
    {
        $qb = $this->getQueryBuilder();

        $optionValues = $qb->select('optionValue')
            ->from('kommerce:OptionValue', 'optionValue')

            ->addSelect('option')
            ->innerJoin('optionValue.option', 'option')

            ->addSelect('product')
            ->leftJoin('optionValue.product', 'product')

            ->where('optionValue.id IN (:optionValueIds)')
            ->setParameter('optionValueIds', $optionValueIds)
            ->paginate($pagination)
            ->getQuery()
            ->getResult();

        return $optionValues;
    }
}
