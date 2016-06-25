<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\EntityRepository\ImageRepositoryInterface;
use inklabs\kommerce\EntityRepository\TagRepositoryInterface;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\Lib\UuidInterface;

class TagService implements TagServiceInterface
{
    use EntityValidationTrait;

    /** @var TagRepositoryInterface */
    private $tagRepository;

    /** @var ImageRepositoryInterface */
    private $imageRepository;

    public function __construct(
        TagRepositoryInterface $tagRepository,
        ImageRepositoryInterface $imageRepository
    ) {
        $this->tagRepository = $tagRepository;
        $this->imageRepository = $imageRepository;
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

    public function delete(Tag $tag)
    {
        $this->tagRepository->delete($tag);
    }

    /**
     * @param UuidInterface $tagId
     * @param UuidInterface $imageId
     * @throws EntityNotFoundException
     */
    public function removeImage(UuidInterface $tagId, UuidInterface $imageId)
    {
        $tag = $this->tagRepository->findOneById($tagId);
        $image = $this->imageRepository->findOneById($imageId);

        $tag->removeImage($image);

        $this->tagRepository->update($tag);

        if ($image->getProduct() === null) {
            $this->imageRepository->delete($image);
        }
    }

    public function findOneById(UuidInterface $id)
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
