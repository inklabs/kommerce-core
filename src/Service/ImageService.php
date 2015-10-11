<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Image;
use inklabs\kommerce\EntityRepository\EntityNotFoundException;
use inklabs\kommerce\EntityRepository\ImageRepositoryInterface;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;

class ImageService extends AbstractService
{
    /** @var ImageRepositoryInterface */
    private $imageRepository;

    /** @var ProductRepositoryInterface */
    private $productRepository;

    public function __construct(
        ImageRepositoryInterface $imageRepository,
        ProductRepositoryInterface $productRepository
    ) {
        $this->imageRepository = $imageRepository;
        $this->productRepository = $productRepository;
    }

    public function create(Image & $image)
    {
        $this->throwValidationErrors($image);
        $this->imageRepository->create($image);
    }

    public function edit(Image & $image)
    {
        $this->throwValidationErrors($image);
        $this->imageRepository->save($image);
    }

    /**
     * @param Image $image
     * @param int $productId
     * @throws \LogicException
     */
    public function createWithProduct(Image & $image, $productId)
    {
        try {
            $product = $this->productRepository->findOneById($productId);
        } catch (EntityNotFoundException $e) {
            throw new \LogicException('Missing Product');
        }

        if ($product->getDefaultImage() === null) {
            $product->setDefaultImage($image->getPath());
        }

        $image->setProduct($product);
        $this->create($image);
    }

    /**
     * @param int $id
     * @return Image|null
     */
    public function findOneById($id)
    {
        return $this->imageRepository->findOneById($id);
    }
}
