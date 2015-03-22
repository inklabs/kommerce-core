<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\tests\Helper as Helper;

class ImageTest extends Helper\DoctrineTestCase
{
    /**
     * @return Image
     */
    private function getRepository()
    {
        return $this->entityManager->getRepository('kommerce:Image');
    }

    public function setupImageWithProductAndTag()
    {
        $product = $this->getDummyProduct();
        $tag = $this->getDummyTag();

        $image = $this->getDummyImage();
        $image->setProduct($product);
        $image->setTag($tag);

        $this->entityManager->persist($image);
        $this->entityManager->persist($product);
        $this->entityManager->persist($tag);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function testFind()
    {
        $this->setupImageWithProductAndTag();

        $this->setCountLogger();

        $image = $this->getRepository()
            ->find(1);

        $image->getProduct()->getName();
        $image->getTag()->getName();

        $this->assertTrue($image instanceof Entity\Image);
        $this->assertSame(1, $this->countSQLLogger->getTotalQueries());
    }
}
