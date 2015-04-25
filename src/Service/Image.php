<?php
namespace inklabs\kommerce\Service;

use Symfony\Component\Validator\Exception\ValidatorException;
use inklabs\kommerce\EntityRepository;
use inklabs\kommerce\View;
use inklabs\kommerce\Entity;
use inklabs\kommerce\Lib;

class Image extends Lib\ServiceManager
{
    /** @var EntityRepository\Image */
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
     * @param int $id
     * @param View\Image $viewImage
     * @return Entity\Image
     * @throws ValidatorException
     */
    public function edit($id, View\Image $viewImage)
    {
        /** @var Entity\Image $image */
        $image = $this->imageRepository->find($id);

        if ($image === null) {
            throw new \LogicException('Missing Image');
        }

        $image->loadFromView($viewImage);

        $this->throwValidationErrors($image);

        $this->imageRepository->save($image);

        return $image;
    }

    /**
     * @param Entity\Image $viewImage
     * @return Entity\Image
     * @throws ValidatorException
     */
    public function create(View\Image $viewImage)
    {
        $image = new Entity\Image;
        $image->loadFromView($viewImage);

        $this->throwValidationErrors($image);

        $this->imageRepository->save($image);

        return $image;
    }

    /**
     * @param View\Image $viewImage
     * @return Entity\Image
     * @throws ValidatorException
     */
    public function createWithProduct(View\Image $viewImage, $productId)
    {
        $product = $this->productRepository->find($productId);

        if ($product === null) {
            throw new \LogicException('Missing Product');
        }

        $image = $this->create($viewImage);
        $image->setProduct($product);

        if ($product->getDefaultImage() === null) {
            $product->setDefaultImage($image->getPath());
        }

        $this->imageRepository->save($image);

        return $image;
    }
}
