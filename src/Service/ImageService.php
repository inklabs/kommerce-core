<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Image;
use inklabs\kommerce\EntityDTO\ImageDTO;
use inklabs\kommerce\EntityRepository\ImageRepositoryInterface;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;
use inklabs\kommerce\EntityRepository\TagRepositoryInterface;
use Ramsey\Uuid\UuidInterface;

class ImageService implements ImageServiceInterface
{
    use EntityValidationTrait;

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

    public function createFromDTOWithTag(ImageDTO $imageDTO, UuidInterface $tagId = null)
    {
        $image = new Image;
        $this->setFromDTO($image, $imageDTO);

        if ($tagId !== null) {
            $tag = $this->tagRepository->findOneById($tagId);
            $tag->addImage($image);
        }

        $this->create($image);
    }

    public function setFromDTO(Image & $image, ImageDTO $imageDTO)
    {
        $image->setpath($imageDTO->path);
        $image->setWidth($imageDTO->width);
        $image->setHeight($imageDTO->height);
        $image->setSortOrder($imageDTO->sortOrder);
    }

    public function createWithProduct(Image & $image, UuidInterface $productId)
    {
        $product = $this->productRepository->findOneById($productId);

        if ($product->getDefaultImage() === null) {
            $product->setDefaultImage($image->getPath());
        }

        $image->setProduct($product);
        $this->create($image);
    }

    public function findOneById(UuidInterface $id)
    {
        return $this->imageRepository->findOneById($id);
    }
}
