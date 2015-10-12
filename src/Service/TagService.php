<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\EntityDTO\TagDTO;
use inklabs\kommerce\EntityRepository\TagRepositoryInterface;

class TagService extends AbstractService implements TagServiceInterface
{
    /** @var TagRepositoryInterface */
    private $tagRepository;

    public function __construct(TagRepositoryInterface $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function create(Tag & $tag)
    {
        $this->throwValidationErrors($tag);
        $this->tagRepository->create($tag);
    }

    public function update(Tag & $tag)
    {
        $this->throwValidationErrors($tag);
        $this->tagRepository->update($tag);
    }

    public function createFromDTO(TagDTO $tagDTO)
    {
        $tag = new Tag;
        $this->setFromDTO($tag, $tagDTO);
        $this->create($tag);
    }

    public function updateFromDTO(TagDTO $tagDTO)
    {
        $tag = $this->tagRepository->findOneById($tagDTO->id);
        $this->setFromDTO($tag, $tagDTO);
        $this->update($tag);
    }

    public function delete($tagId)
    {
        $tag = $this->tagRepository->findOneById($tagId);
        $this->tagRepository->delete($tag);
    }

    private function setFromDTO(Tag & $tag, TagDTO $tagDTO)
    {
        $tag->setName($tagDTO->name);
        $tag->setCode($tagDTO->code);
        $tag->setDescription($tagDTO->description);
        $tag->setIsActive($tagDTO->isActive);
        $tag->setIsVisible($tagDTO->isVisible);
        $tag->setSortOrder($tagDTO->sortOrder);
    }

    public function findOneById($id)
    {
        return $this->tagRepository->findOneById($id);
    }

    public function findOneByCode($code)
    {
        return $this->tagRepository->findOneByCode($code);
    }

    public function getAllTags($queryString = null, Pagination & $pagination = null)
    {
        return $this->tagRepository->getAllTags($queryString, $pagination);
    }

    public function getTagsByIds($tagIds, Pagination & $pagination = null)
    {
        return $this->tagRepository->getTagsByIds($tagIds, $pagination);
    }

    public function getAllTagsByIds($tagIds, Pagination & $pagination = null)
    {
        return $this->tagRepository->getAllTagsByIds($tagIds, $pagination);
    }
}
