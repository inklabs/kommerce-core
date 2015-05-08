<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\EntityRepository;
use inklabs\kommerce\View;
use inklabs\kommerce\Entity;

class Image extends AbstractService
{
    /** @var EntityRepository\ImageInterface */
    private $imageRepository;

    /** @var EntityRepository\ProductInterface */
    private $productRepository;

    public function __construct(
        EntityRepository\ImageInterface $imageRepository,
        EntityRepository\ProductInterface $productRepository
    ) {
        $this->imageRepository = $imageRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * @return View\Image|null
     */
    public function find($id)
    {
        $image = $this->imageRepository->find($id);

        if ($image === null) {
            return null;
        }

        return $image->getView()
            ->withAllData()
            ->export();
    }

    /**
     * @param Entity\Image $image
     * @return Entity\Image
     */
    public function edit(Entity\Image $image)
    {
        $this->throwValidationErrors($image);
        $this->imageRepository->save($image);
        return $image;
    }

    /**
     * @param Entity\Image $image
     * @return Entity\Image
     */
    public function create(Entity\Image $image)
    {
        $this->throwValidationErrors($image);
        $this->imageRepository->create($image);
        return $image;
    }

    /**
     * @param Entity\Image $image
     * @param $productId
     * @return Entity\Image
     */
    public function createWithProduct(Entity\Image $image, $productId)
    {
        $product = $this->productRepository->find($productId);

        if ($product === null) {
            throw new \LogicException('Missing Product');
        }

        if (empty($product->getDefaultImage())) {
            $product->setDefaultImage($image->getPath());
        }

        $image->setProduct($product);
        $this->imageRepository->create($image);

        return $image;
    }
}
