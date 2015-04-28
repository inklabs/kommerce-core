<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

class OptionValue extends AbstractEntityRepository implements OptionValueInterface
{
    public function find($id)
    {
        $qb = $this->getQueryBuilder();

        $optionValues = $qb->select('OptionValue')
            ->from('kommerce:OptionValue', 'OptionValue')

            ->addSelect('Option')
            ->innerJoin('OptionValue.option', 'Option')

            ->where('OptionValue.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();

        return $optionValues[0];
    }

    public function getAllOptionValuesByIds($optionValueIds, Entity\Pagination & $pagination = null)
    {
        $qb = $this->getQueryBuilder();

        $optionValues = $qb->select('OptionValue')
            ->from('kommerce:OptionValue', 'OptionValue')

            ->addSelect('Option')
            ->innerJoin('OptionValue.option', 'Option')

            ->where('OptionValue.id IN (:optionValueIds)')
            ->setParameter('optionValueIds', $optionValueIds)
            ->paginate($pagination)
            ->getQuery()
            ->getResult();

        return $optionValues;
    }
}
