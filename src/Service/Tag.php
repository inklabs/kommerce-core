<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity;
use inklabs\kommerce\View;
use inklabs\kommerce\Lib;
use inklabs\kommerce\EntityRepository;
use Symfony\Component\Validator\Exception\ValidatorException;

class Tag extends Lib\ServiceManager
{
    /** @var Pricing */
    private $pricing;

    /** @var EntityRepository\Tag */
    private $repository;

    public function __construct(EntityRepository\TagInterface $repository, Pricing $pricing)
    {
        $this->pricing = $pricing;
        $this->repository = $repository;
    }

    /**
     * @return View\Tag|null
     */
    public function find($id)
    {
        $entityTag = $this->repository->find($id);

        if ($entityTag === null) {
            return null;
        }

        return $entityTag->getView()
            ->withAllData($this->pricing)
            ->export();
    }

    /**
     * @param string $encodedId
     * @return View\Tag|null
     */
    public function findSimple($encodedId)
    {
        $entityTag = $this->repository->find(Lib\BaseConvert::decode($encodedId));

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
    public function edit($id, View\Tag $viewTag)
    {
        $tag = $this->repository->find($id);

        if ($tag === null) {
            throw new \LogicException('Missing Tag');
        }

        $tag->loadFromView($viewTag);

        $this->throwValidationErrors($tag);

        $this->repository->save($tag);

        return $tag;
    }

    /**
     * @return Entity\Tag
     * @throws ValidatorException
     */
    public function create(View\Tag $viewTag)
    {
        $tag = new Entity\Tag;
        $tag->loadFromView($viewTag);

        $this->throwValidationErrors($tag);

        $this->repository->save($tag);

        return $tag;
    }

    public function getAllTags($queryString = null, Entity\Pagination & $pagination = null)
    {
        $tags = $this->repository
            ->getAllTags($queryString, $pagination);

        return $this->getViewTags($tags);
    }

    public function getTagsByIds($tagIds, Entity\Pagination & $pagination = null)
    {
        $tags = $this->repository
            ->getTagsByIds($tagIds);

        return $this->getViewTags($tags);
    }

    public function getAllTagsByIds($tagIds, Entity\Pagination & $pagination = null)
    {
        $tags = $this->repository
            ->getAllTagsByIds($tagIds);

        return $this->getViewTags($tags);
    }

    /**
     * @param Entity\Tag[] $tags
     * @return View\Tag[]
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
