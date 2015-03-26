<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;
use inklabs\kommerce\EntityRepository as EntityRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Exception\ValidatorException;

class Tag extends Lib\ServiceManager
{
    /** @var Pricing */
    private $pricing;

    /** @var EntityRepository\Tag */
    private $tagRepository;

    public function __construct(EntityManager $entityManager, Pricing $pricing)
    {
        $this->setEntityManager($entityManager);
        $this->pricing = $pricing;
        $this->tagRepository = $entityManager->getRepository('kommerce:Tag');
    }

    /**
     * @return Entity\View\Tag|null
     */
    public function find($id)
    {
        /** @var Entity\Tag $entityTag */
        $entityTag = $this->tagRepository->find($id);

        if ($entityTag === null) {
            return null;
        }

        return $entityTag->getView()
            ->withAllData($this->pricing)
            ->export();
    }

    /**
     * @param string $encodedId
     * @return Entity\View\Tag|null
     */
    public function findSimple($encodedId)
    {
        /** @var Entity\Tag $entityTag */
        $entityTag = $this->tagRepository->find(Lib\BaseConvert::decode($encodedId));

        if ($entityTag === null) {
            return null;
        }

        return $entityTag->getView()
            ->export();
    }

    /**
     * @return Entity\Tag
     * @throws ValidatorException
     */
    public function edit($id, Entity\View\Tag $viewTag)
    {
        /** @var Entity\Tag $tag */
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
        /** @var Entity\Tag $tag */
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
