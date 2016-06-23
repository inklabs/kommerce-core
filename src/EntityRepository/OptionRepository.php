<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\OptionValue;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Lib\UuidInterface;

class OptionRepository extends AbstractRepository implements OptionRepositoryInterface
{
    /**
     * @param UuidInterface $optionValueId
     * @return OptionValue
     */
    public function getOptionValueById(UuidInterface $optionValueId)
    {
        return $this->returnOrThrowNotFoundException(
            $this->getQueryBuilder()
                ->select('OptionValue')
                ->from(OptionValue::class, 'OptionValue')
                ->where('OptionValue.id = :id')
                ->setIdParameter('id', $optionValueId)
                ->getQuery()
                ->getOneOrNullResult(),
            OptionValue::class
        );
    }

    public function getAllOptionsByIds(array $optionIds, Pagination & $pagination = null)
    {
        return $this->getQueryBuilder()
            ->select('Option')
            ->from(Option::class, 'Option')
            ->where('Option.id IN (:optionIds)')
            ->setIdParameter('optionIds', $optionIds)
            ->paginate($pagination)
            ->getQuery()
            ->getResult();
    }

    public function getAllOptions($queryString, Pagination & $pagination = null)
    {
        $query = $this->getQueryBuilder()
            ->select('option')
            ->from(Option::class, 'option');

        if (trim($queryString) !== '') {
            $query
                ->where('option.name LIKE :query')
                ->orWhere('option.description LIKE :query')
                ->setParameter('query', '%' . $queryString . '%');
        }

        return $query
            ->paginate($pagination)
            ->getQuery()
            ->getResult();
    }
}
