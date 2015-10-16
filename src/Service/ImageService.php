<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Image;
use inklabs\kommerce\EntityDTO\ImageDTO;
use inklabs\kommerce\EntityRepository\EntityNotFoundException;
use inklabs\kommerce\EntityRepository\ImageRepositoryInterface;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;
use inklabs\kommerce\EntityRepository\TagRepository;
use inklabs\kommerce\EntityRepository\TagRepositoryInterface;

class ImageService extends AbstractService implements ImageServiceInterface
{
    /** @var ImageRepositoryInterface */
    private $imageRepository;

    /** @var ProductRepositoryInterface */
    private $productRepository;

    /** @var TagRepositoryInterface */
    private $tagRepository;

    public function __construct(
        ImageRepositoryInterface $imageRepository,
        ProductRepositoryInterface $productRepository,
        TagRepositoryInterface $tagRepository
    ) {
        $this->imageRepository = $imageRepository;
        $this->productRepository = $productRepository;
        $this->tagRepository = $tagRepository;
    }

    public function create(Image & $image)
    {
        $this->throwValidationErrors($image);
        $this->imageRepository->create($image);
    }

    public function update(Image & $image)
    {
        $this->throwValidationErrors($image);
        $this->imageRepository->update($image);
    }

    public function createFromDTO(ImageDTO $imageDTO)
    {
        $image = new Image;
        $this->setFromDTO($image, $imageDTO);
        $this->create($image);
    }

    public function createFromDTOWithTag(ImageDTO $imageDTO, $tagId = null)
    {
        $image = new Image;
        $this->setFromDTO($image, $imageDTO);

        if ($tagId !== null) {
            $tag = $this->tagRepository->findOneById($tagId);
            $tag->addImage($image);
        }

        $this->create($image);
    }

    public function updateFromDTO(ImageDTO $imageDTO)
    {
        $image = $this->imageRepository->findOneById($imageDTO->id);
        $this->setFromDTO($image, $imageDTO);
        $this->update($image);
    }

    public function delete($imageId)
    {
        $image = $this->imageRepository->findOneById($imageId);
        $this->imageRepository->delete($image);
    }

    public function setFromDTO(Image & $image, ImageDTO $imageDTO)
    {
        $image->setpath($imageDTO->path);
        $image->setWidth($imageDTO->width);
        $image->setHeight($imageDTO->height);
        $image->setSortOrder($imageDTO->sortOrder);
    }

    /**
     * @param Image $image
     * @param int $productId
     * @throws EntityNotFoundException
     */
    public function createWithProduct(Image & $image, $productId)
    {
        $product = $this->productRepository->findOneById($productId);

        if ($product->getDefaultImage() === null) {
            $product->setDefaultImage($image->getPath());
        }

        $image->setProduct($product);
        $this->create($image);
    }

    /**
     * @param int $id
     * @return Image
     * @throws EntityNotFoundException
     */
    public function findOneById($id)
    {
        return $this->imageRepository->findOneById($id);
    }
}
