<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

class Option extends AbstractEntityRepository implements OptionInterface
{
    public function getAllOptionsByIds(array $optionIds, Entity\Pagination & $pagination = null)
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

    public function getAllOptions($queryString, Entity\Pagination & $pagination = null)
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

    public function save(Entity\Option & $option)
    {
        $this->saveEntity($option);
    }

    public function create(Entity\Option & $option)
    {
        $this->persist($option);
        $this->flush();
    }

    public function persist(Entity\Option & $option)
    {
        $this->persistEntity($option);
    }
}
