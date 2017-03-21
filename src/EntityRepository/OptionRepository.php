<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\OptionProduct;
use inklabs\kommerce\Entity\OptionValue;
use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Lib\UuidInterface;

class OptionRepository extends AbstractRepository implements OptionRepositoryInterface
{
    /**
     * @param UuidInterface $optionProductId
     * @return OptionProduct
     */
    public function getOptionProductById(UuidInterface $optionProductId)
    {
        return $this->returnOrThrowNotFoundException(
            $this->getQueryBuilder()
                ->select('OptionProduct')
                ->from(OptionProduct::class, 'OptionProduct')
                ->where('OptionProduct.id = :id')
                ->setIdParameter('id', $optionProductId)
                ->getQuery()
                ->getOneOrNullResult(),
            OptionProduct::class
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
