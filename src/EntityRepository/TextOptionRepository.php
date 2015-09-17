<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

class TextOptionRepository extends AbstractRepository implements TextOptionRepositoryInterface
{
    public function save(Entity\TextOption & $textOption)
    {
        $this->saveEntity($textOption);
    }

    public function create(Entity\TextOption & $textOption)
    {
        $this->createEntity($textOption);
    }

    public function remove(Entity\TextOption & $textOption)
    {
        $this->removeEntity($textOption);
    }

    public function getAllTextOptionsByIds($optionIds, Entity\Pagination & $pagination = null)
    {
        $qb = $this->getQueryBuilder();

        $options = $qb->select('TextOption')
            ->from('kommerce:TextOption', 'TextOption')
            ->where('TextOption.id IN (:optionIds)')
            ->setParameter('optionIds', $optionIds)
            ->paginate($pagination)
            ->getQuery()
            ->getResult();

        return $options;
    }
}
