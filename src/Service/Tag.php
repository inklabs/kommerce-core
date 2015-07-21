<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity;
use inklabs\kommerce\EntityRepository;

class Tag extends AbstractService
{
    /** @var EntityRepository\TagInterface */
    private $tagRepository;

    public function __construct(EntityRepository\TagInterface $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function create(Entity\Tag & $tag)
    {
        $this->throwValidationErrors($tag);
        $this->tagRepository->create($tag);
    }

    public function edit(Entity\Tag & $tag)
    {
        $this->throwValidationErrors($tag);
        $this->tagRepository->save($tag);
    }

    /**
     * @param int $id
     * @return Entity\Tag|null
     */
    public function find($id)
    {
        return $this->tagRepository->find($id);
    }

    /**
     * @param string $code
     * @return Entity\Tag|null
     */
    public function findOneByCode($code)
    {
        return $this->tagRepository->findOneBy([
            'code' => $code
        ]);
    }

    /**
     * @param int $id
     * @return Entity\Tag|null
     */
    public function findSimple($id)
    {
        return $this->tagRepository->find($id);
    }

    /**
     * @param int $tagId
     * @return Entity\Tag
     * @throws \LogicException
     */
    public function getTagAndThrowExceptionIfMissing($tagId)
    {
        $tag = $this->tagRepository->find($tagId);

        if ($tag === null) {
            throw new \LogicException('Missing Tag');
        }

        return $tag;
    }

    public function getAllTags($queryString = null, Entity\Pagination & $pagination = null)
    {
        return $this->tagRepository->getAllTags($queryString, $pagination);
    }

    public function getTagsByIds($tagIds, Entity\Pagination & $pagination = null)
    {
        return $this->tagRepository->getTagsByIds($tagIds, $pagination);
    }

    public function getAllTagsByIds($tagIds, Entity\Pagination & $pagination = null)
    {
        return $this->tagRepository->getAllTagsByIds($tagIds, $pagination);
    }
}
