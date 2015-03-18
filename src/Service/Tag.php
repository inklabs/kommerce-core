<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;
use inklabs\kommerce\EntityRepository as EntityRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Exception\ValidatorException;

class Tag extends Lib\ServiceManager
{
    /* @var EntityRepository\Tag */
    private $tagRepository;

    public function __construct(EntityManager $entityManager)
    {
        $this->setEntityManager($entityManager);
        $this->tagRepository = $entityManager->getRepository('kommerce:Tag');
    }

    /**
     * @return Entity\View\Tag|null
     */
    public function find($id)
    {
        /* @var Entity\Tag $entityTag */
        $entityTag = $this->tagRepository->find($id);

        if ($entityTag === null) {
            return null;
        }

        return $entityTag->getView()
            ->withImages()
            ->withProducts(new Pricing)
            ->withOptions()
            ->export();
    }

    /**
     * @return Entity\Tag
     * @throws ValidatorException
     */
    public function edit($id, Entity\View\Tag $viewTag)
    {
        /* @var Entity\Tag $tag */
        $tag = $this->tagRepository->find($id);

        if ($tag === null) {
            throw new \LogicException('Missing Tag');
        }

        $tag->loadFromView($viewTag);

        $this->throwValidationErrors($tag);

        $this->entityManager->flush();

        return $tag;
    }

    /**
     * @return Entity\Tag
     * @throws ValidatorException
     */
    public function create(Entity\View\Tag $viewTag)
    {
        /* @var Entity\Tag $tag */
        $tag = new Entity\Tag;

        $tag->loadFromView($viewTag);

        $this->throwValidationErrors($tag);

        $this->entityManager->persist($tag);
        $this->entityManager->flush();

        return $tag;
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

    public function getAllTagsByIds($tagIds, Entity\Pagination & $pagination = null)
    {
        $tags = $this->tagRepository
            ->getAllTagsByIds($tagIds);

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
