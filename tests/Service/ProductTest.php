<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity as Entity;

class ProductTest extends DoctrineTestCase
{
    public function setUp()
    {
        $this->entityManager->clear();

        $tool = new \Doctrine\ORM\Tools\SchemaTool($this->entityManager);
        $classes = $this->entityManager->getMetaDataFactory()->getAllMetaData();

        $tool->dropSchema($classes);
        $tool->createSchema($classes);

        $this->product = new Entity\Product;
        $this->product->setSku('TST101');
        $this->product->setName('Test Product');
        $this->product->setPrice(500);
        $this->product->setQuantity(10);
        $this->product->setIsInventoryRequired(true);
        $this->product->setIsPriceVisible(true);
        $this->product->setIsActive(true);
        $this->product->setIsVisible(true);
        $this->product->setIsTaxable(true);
        $this->product->setIsShippable(true);
        $this->product->setShippingWeight(16);
        $this->product->setDescription('Test product description');
        $this->product->setRating(null);
        $this->product->setDefaultImage(null);
        $this->product->setCreated(new \DateTime('now', new \DateTimeZone('UTC')));

        $this->entityManager->persist($this->product);
        $this->entityManager->flush();
    }

    public function testFindMissing()
    {
        $product = (new Product($this->entityManager))->find(0);
        $this->assertEquals(null, $product);
    }

    public function testFindNotActive()
    {
        $this->product->setIsActive(false);
        $id = $this->product->getId();

        $product = new Product($this->entityManager);
        $product = $product->find($id);

        $this->assertEquals(null, $product);
    }

    public function testFind()
    {
        $id = $this->product->getId();

        $product = new Product($this->entityManager);
        $product = $product->find($id);

        $this->assertEquals($this->product, $product);
    }
}
