<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity;
use inklabs\kommerce\EntityRepository\TagRepositoryInterface;

class Tag extends AbstractService
{
    /** @var TagRepositoryInterface */
    private $tagRepository;

    public function __construct(TagRepositoryInterface $tagRepository)
    {
        $this->tagRepository = $tagRepository;
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

    /**
     * @param string $queryString
     * @param Entity\Pagination $pagination
     * @return Entity\Tag[]
     */
    public function getAllTags($queryString = null, Entity\Pagination & $pagination = null)
    {
        return $this->tagRepository->getAllTags($queryString, $pagination);
    }

    /**
     * @param int[] $tagIds
     * @param Entity\Pagination $pagination
     * @return Entity\Tag[]
     */
    public function getTagsByIds($tagIds, Entity\Pagination & $pagination = null)
    {
        return $this->tagRepository->getTagsByIds($tagIds, $pagination);
    }

    public function getAllTagsByIds($tagIds, Entity\Pagination & $pagination = null)
    {
        return $this->tagRepository->getAllTagsByIds($tagIds, $pagination);
    }
}
