<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity;
use inklabs\kommerce\EntityRepository\ImageRepositoryInterface;
use inklabs\kommerce\EntityRepository\ProductRepositoryInterface;

class Image extends AbstractService
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

    public function create(Entity\Image & $image)
    {
        $this->throwValidationErrors($image);
        $this->imageRepository->create($image);
    }

    public function edit(Entity\Image & $image)
    {
        $this->throwValidationErrors($image);
        $this->imageRepository->save($image);
    }

    /**
     * @param Entity\Image $image
     * @param int $productId
     * @throws \LogicException
     */
    public function createWithProduct(Entity\Image & $image, $productId)
    {
        $product = $this->productRepository->find($productId);
        if ($product === null) {
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
     * @return Entity\Image|null
     */
    public function find($id)
    {
        return $this->imageRepository->find($id);
    }
}
