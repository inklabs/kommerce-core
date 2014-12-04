<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\tests\Helper as Helper;

class TagTest extends Helper\DoctrineTestCase
{
    /* @var Tag */
    protected $tagService;

    /* @var Entity\Tag */
    protected $tag;

    public function setUp()
    {
        $this->tagService = new Tag($this->entityManager);
    }

    private function setupTag()
    {
        $this->tag = new Entity\Tag;
        $this->tag->setName('Test Tag');
        $this->tag->setDescription('Test Description');
        $this->tag->setDefaultImage('http://lorempixel.com/400/200/');
        $this->tag->setSortOrder(0);
        $this->tag->setIsVisible(true);
        $this->tag->setIsActive(true);

        $product1 = $this->getDummyProduct(1);
        $product2 = $this->getDummyProduct(2);
        $product3 = $this->getDummyProduct(3);

        $product1->addTag($this->tag);
        $product2->addTag($this->tag);
        $product3->addTag($this->tag);

        $this->entityManager->persist($this->tag);
        $this->entityManager->persist($product1);
        $this->entityManager->persist($product2);
        $this->entityManager->persist($product3);
        $this->entityManager->flush();
    }

    /**
     * @return Entity\Product
     */
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

    public function testFindMissing()
    {
        $tag = $this->tagService->find(0);
        $this->assertEquals(null, $tag);
    }

    public function testFindNotActive()
    {
        $this->setupTag();
        $this->tag->setIsActive(false);
        $this->entityManager->flush();

        $tag = $this->tagService->find(1);
        $this->assertEquals(null, $tag);
    }

    public function testFind()
    {
        $this->setupTag();
        $tag = $this->tagService->find(1);
        $this->assertEquals(1, $tag->id);
    }
}
