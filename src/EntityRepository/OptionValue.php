<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

class OptionValue extends AbstractEntityRepository
{
    /**
     * @return Entity\OptionValue\AbstractOptionValue
     */
    public function find($id, $lockMode = null, $lockVersion = null)
    {
        $qb = $this->getQueryBuilder();

        $optionValues = $qb->select('OptionValue')
            ->from('kommerce:OptionValue\AbstractOptionValue', 'OptionValue')

            ->addSelect('OptionType')
            ->innerJoin('OptionValue.optionType', 'OptionType')

//            ->addSelect('Product')
//            ->leftJoin('OptionValue.product', 'Product')

            ->where('OptionValue.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();

        return $optionValues[0];
    }

    /**
     * @return Entity\OptionValue\AbstractOptionValue[]
     */
    public function getAllOptionValuesByIds($optionValueIds, Entity\Pagination & $pagination = null)
    {
        $qb = $this->getQueryBuilder();

        $optionValues = $qb->select('OptionValue')
            ->from('kommerce:OptionValue\AbstractOptionValue', 'OptionValue')

            ->addSelect('OptionType')
            ->innerJoin('OptionValue.optionType', 'OptionType')

//            ->addSelect('Product')
//            ->leftJoin('OptionValue.product', 'Product')

            ->where('OptionValue.id IN (:optionValueIds)')
            ->setParameter('optionValueIds', $optionValueIds)
            ->paginate($pagination)
            ->getQuery()
            ->getResult();

        return $optionValues;
    }
}
