<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\OptionValue;
use inklabs\kommerce\Entity\Pagination;
use Ramsey\Uuid\UuidInterface;

class OptionValueRepository extends AbstractRepository implements OptionValueRepositoryInterface
{
    public function findOneById(UuidInterface $id)
    {
        return $this->getQueryBuilder()
            ->select('OptionValue')
            ->from(OptionValue::class, 'OptionValue')

            ->addSelect('Option')
            ->innerJoin('OptionValue.option', 'Option')

            ->where('OptionValue.id = :id')
            ->setIdParameter('id', $id)
            ->getQuery()
            ->getSingleResult();
    }

    public function getAllOptionValuesByIds(array $optionValueIds, Pagination & $pagination = null)
    {
        return $this->getQueryBuilder()
            ->select('OptionValue')
            ->from(OptionValue::class, 'OptionValue')

            ->addSelect('Option')
            ->innerJoin('OptionValue.option', 'Option')

            ->where('OptionValue.id IN (:optionValueIds)')
            ->setIdParameter('optionValueIds', $optionValueIds)
            ->paginate($pagination)
            ->getQuery()
            ->getResult();
    }
}
