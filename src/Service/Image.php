<?php
namespace inklabs\kommerce\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Exception\ValidatorException;
use inklabs\kommerce\EntityRepository as EntityRepository;
use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\Lib as Lib;

class Image extends Lib\ServiceManager
{
    /* @var EntityRepository\Image */
    private $ImageRepository;

    public function __construct(EntityManager $entityManager)
    {
        $this->setEntityManager($entityManager);
        $this->imageRepository = $entityManager->getRepository('kommerce:Image');
    }

    /**
     * @return Entity\View\Image|null
     */
    public function find($id)
    {
        /* @var Entity\Image $entityImage */
        $entityImage = $this->imageRepository->find($id);

        if ($entityImage === null) {
            return null;
        }

        return $entityImage->getView()
            ->withAllData()
            ->export();
    }

    /**
     * @return Entity\Image
     * @throws ValidatorException
     */
    public function edit($id, Entity\View\Image $viewImage)
    {
        /* @var Entity\Image $image */
        $image = $this->imageRepository->find($id);

        if ($image === null) {
            throw new \LogicException('Missing Image');
        }

        $image->loadFromView($viewImage);

        $this->throwValidationErrors($image);

        $this->entityManager->flush();

        return $image;
    }

    /**
     * @return Entity\Image
     * @throws ValidatorException
     */
    public function create(Entity\Image $image)
    {
        $this->throwValidationErrors($image);

        $this->entityManager->persist($image);
        $this->entityManager->flush();

        return $image;
    }

    /**
     * @return Entity\Image
     * @throws ValidatorException
     */
    public function createWithProduct(Entity\Image $image, $productId)
    {
        /* @var Entity\Product $product */
        $product = $this->entityManager->getRepository('kommerce:Product')->find($productId);

        if ($product === null) {
            throw new \LogicException('Missing Product');
        }

        $image->setProduct($product);

        if ($product->getDefaultImage() === null) {
            $product->setDefaultImage($image->getPath());
        }

        return $this->create($image);
    }
}
