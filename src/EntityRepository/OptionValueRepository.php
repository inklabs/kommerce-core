<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Pagination;

class OptionValueRepository extends AbstractRepository implements OptionValueRepositoryInterface
{
    public function findOneById($id)
    {
        return $this->getQueryBuilder()
            ->select('OptionValue')
            ->from('kommerce:OptionValue', 'OptionValue')

            ->addSelect('Option')
            ->innerJoin('OptionValue.option', 'Option')

            ->where('OptionValue.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getSingleResult();
    }

    public function getAllOptionValuesByIds(array $optionValueIds, Pagination & $pagination = null)
    {
        return $this->getQueryBuilder()
            ->select('OptionValue')
            ->from('kommerce:OptionValue', 'OptionValue')

            ->addSelect('Option')
            ->innerJoin('OptionValue.option', 'Option')

            ->where('OptionValue.id IN (:optionValueIds)')
            ->setParameter('optionValueIds', $optionValueIds)
            ->paginate($pagination)
            ->getQuery()
            ->getResult();
    }
}
