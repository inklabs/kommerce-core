<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Pagination;

class OptionRepository extends AbstractRepository implements OptionRepositoryInterface
{
    public function getAllOptionsByIds(array $optionIds, Pagination & $pagination = null)
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

    public function getAllOptions($queryString, Pagination & $pagination = null)
    {
        $qb = $this->getQueryBuilder();

        $options = $qb->select('option')
            ->from('kommerce:Option', 'option');

        if ($queryString !== null) {
            $options = $options
                ->where('option.name LIKE :query')
                ->orWhere('option.description LIKE :query')
                ->setParameter('query', '%' . $queryString . '%');
        }

        $options = $options
            ->paginate($pagination)
            ->getQuery()
            ->getResult();

        return $options;
    }
}
