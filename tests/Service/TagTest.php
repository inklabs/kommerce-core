<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\tests\Helper as Helper;

class TagTest extends Helper\DoctrineTestCase
{
    public function setUp()
    {
        $this->tag = new Entity\Tag;
        $this->tag->setName('Test Tag');
        $this->tag->setDescription('Test Description');
        $this->tag->setDefaultImage('http://lorempixel.com/400/200/');
        $this->tag->setIsProductGroup(false);
        $this->tag->setSortOrder(0);
        $this->tag->setIsVisible(true);

        $this->product1 = $this->getDummyProduct(1);
        $this->product2 = $this->getDummyProduct(2);
        $this->product3 = $this->getDummyProduct(3);

        $this->product1->addTag($this->tag);
        $this->product2->addTag($this->tag);
        $this->product3->addTag($this->tag);

        $this->entityManager->persist($this->tag);
        $this->entityManager->persist($this->product1);
        $this->entityManager->persist($this->product2);
        $this->entityManager->persist($this->product3);
        $this->entityManager->flush();
    }

    private function getDummyProduct($num)
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
        $id = $this->tag->getId();

        $tagService = new Tag($this->entityManager);
        $tag = $tagService->find($id);

        $this->assertEquals('Test Tag', $tag->name);
    }
}
