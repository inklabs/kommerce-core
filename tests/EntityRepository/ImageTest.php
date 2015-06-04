<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;
use inklabs\kommerce\tests\Helper;

class ImageTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:Image',
        'kommerce:Tag',
        'kommerce:Product',
    ];

    /** @var ImageInterface */
    protected $imageRepository;

    public function setUp()
    {
        $this->imageRepository = $this->repository()->getImage();
    }

    public function setupImageWithProductAndTag()
    {
        $product = $this->getDummyProduct();
        $tag = $this->getDummyTag();

        $image = $this->getDummyImage();
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
        $image = $this->getDummyImage();

        $this->imageRepository->create($image);
        $this->assertSame(1, $image->getId());

        $image->setPath('New/Path');
        $this->assertSame(null, $image->getUpdated());

        $this->imageRepository->save($image);
        $this->assertTrue($image->getUpdated() instanceof \DateTime);

        $this->imageRepository->remove($image);
        $this->assertSame(null, $image->getId());
    }

    public function testFind()
    {
        $this->setupImageWithProductAndTag();

        $this->setCountLogger();

        $image = $this->imageRepository->find(1);

        $image->getProduct()->getName();
        $image->getTag()->getName();

        $this->assertTrue($image instanceof Entity\Image);
        $this->assertSame(1, $this->countSQLLogger->getTotalQueries());
    }
}
