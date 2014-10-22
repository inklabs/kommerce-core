<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity as Entity;

class EntityManagerTest extends \inklabs\kommerce\tests\Helper\DoctrineTestCase
{
    public function setUp()
    {
        $this->product = new Entity\Product;
        $this->product->setSku('TST101');
        $this->product->setName('Test Product');
        $this->product->setDescription('Test product description');
        $this->product->setPrice(500);
        $this->product->setQuantity(10);
        $this->product->setIsInventoryRequired(true);
        $this->product->setIsPriceVisible(true);
        $this->product->setIsActive(true);
        $this->product->setIsVisible(true);
        $this->product->setIsTaxable(true);
        $this->product->setIsShippable(true);
        $this->product->setShippingWeight(16);
        $this->product->setRating(null);
        $this->product->setDefaultImage(null);
        $this->product->setCreated(new \DateTime('now', new \DateTimeZone('UTC')));

        $this->entityManager->persist($this->product);
        $this->entityManager->flush();
    }

    public function testFindByEncodedId()
    {
        $id = $this->product->getId();
        $encodedId = BaseConvert::encode($id);

        $productService = new Product($this->entityManager);
        $product = $productService->findByEncodedId($encodedId);

        $this->assertEquals($this->product, $product);
    }
}
