<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;
use inklabs\kommerce\EntityRepository as EntityRepository;
use Doctrine\ORM\EntityManager;

class Tag extends Lib\EntityManager
{
    /* @var EntityRepository\Tag */
    private $tagRepository;

    public function __construct(EntityManager $entityManager)
    {
        $this->setEntityManager($entityManager);
        $this->tagRepository = $entityManager->getRepository('kommerce:Tag');
    }

    public function find($id)
    {
        /* @var Entity\Tag $entityTag */
        $entityTag = $this->entityManager->getRepository('kommerce:Tag')->find($id);

        if ($entityTag === null or ! $entityTag->getIsActive()) {
            return null;
        }

        return $entityTag->getView()
            ->export();
    }

    public function getAllTags($queryString = null, Entity\Pagination & $pagination = null)
    {
        $tags = $this->tagRepository
            ->getAllTags($queryString, $pagination);

        return $this->getViewTags($tags);
    }

    public function getTagsByIds($tagIds, Entity\Pagination & $pagination = null)
    {
        $tags = $this->tagRepository
            ->getTagsByIds($tagIds);

        return $this->getViewTags($tags);
    }

    /**
     * @param Entity\Tag[] $tags
     * @return Entity\View\Tag[]
     */
    private function getViewTags($tags)
    {
        $viewTags = [];
        foreach ($tags as $tag) {
            $viewTags[] = $tag->getView()
                ->export();
        }

        return $viewTags;
    }
}
