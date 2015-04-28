<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;

class TextOption extends AbstractEntityRepository implements TextOptionInterface
{
    public function getAllOptionsByIds($optionIds, Entity\Pagination & $pagination = null)
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
