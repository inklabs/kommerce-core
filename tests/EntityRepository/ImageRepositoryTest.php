<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Image;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\tests\Helper\TestCase\EntityRepositoryTestCase;

class ImageRepositoryTest extends EntityRepositoryTestCase
{
    protected $metaDataClassNames = [
        Image::class,
        Tag::class,
        Product::class,
    ];

    /** @var ImageRepositoryInterface */
    protected $imageRepository;

    public function setUp()
    {
        parent::setUp();
        $this->imageRepository = $this->getRepositoryFactory()->getImageRepository();
    }

    public function setupImageWithProductAndTag()
    {
        $product = $this->dummyData->getProduct();
        $tag = $this->dummyData->getTag();

        $image = $this->dummyData->getImage();
        $image->setProduct($product);
        $image->setTag($tag);

        $this->entityManager->persist($product);
        $this->entityManager->persist($tag);

        $this->imageRepository->create($image);

        $this->entityManager->flush();
        $this->entityManager->clear();

        return $image;
    }

    public function testCRUD()
    {
        $this->executeRepositoryCRUD(
            $this->imageRepository,
            $this->dummyData->getImage()
        );
    }

    public function testFindOneById()
    {
        $originalImage = $this->setupImageWithProductAndTag();
        $this->setCountLogger();

        $image = $this->imageRepository->findOneById(
            $originalImage->getId()
        );

        $image->getProduct()->getName();
        $image->getTag()->getName();

        $this->assertEquals($originalImage->getId(), $image->getId());
        $this->assertSame(1, $this->getTotalQueries());
    }

    public function testFindOneByIdThrowsException()
    {
        $this->setExpectedException(
            EntityNotFoundException::class,
            'Image not found'
        );

        $this->imageRepository->findOneById($this->dummyData->getId());
    }
}
