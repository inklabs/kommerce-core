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

    private function getDummyImage()
    {
        $image = new Entity\Image;
        $image->setPath('http://lorempixel.com/400/200/');
        $image->setWidth(400);
        $image->setHeight(200);
        $image->setSortOrder(0);

        return $image;
    }

    private function getDummyTag()
    {
        $tag = new Entity\Tag;
        $tag->setName('Test Tag');
        $tag->setDescription('Test Description');
        $tag->setDefaultImage('http://lorempixel.com/400/200/');
        $tag->setSortOrder(0);
        $tag->setIsActive(true);
        $tag->setIsVisible(true);

        return $tag;
    }

    private function getDummyProduct($num = 1)
    {
        $product = new Entity\Product;
        $product->setSku('TST' . $num);
        $product->setName('Test Product');
        $product->setDescription('Test product description');
        $product->setUnitPrice(500);
        $product->setQuantity(2);
        $product->setIsInventoryRequired(true);
        $product->setIsPriceVisible(true);
        $product->setIsActive(true);
        $product->setIsVisible(true);
        $product->setIsTaxable(true);
        $product->setIsShippable(true);
        $product->setShippingWeight(16);

        return $product;
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
