<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\tests\Helper as Helper;

class ProductTest extends Helper\DoctrineTestCase
{
    public function setUp()
    {
        $pricing = new Pricing(new \DateTime('2014-02-01', new \DateTimeZone('UTC')));
        $this->productService = new Product($this->entityManager, $pricing);

        $this->product = new Entity\Product;
        $this->product->setSku('TST101');
        $this->product->setName('Test Product');
        $this->product->setDescription('Test product description');
        $this->product->setUnitPrice(1000);
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

        $this->entityManager->persist($this->product);
        $this->entityManager->flush();
    }

    public function testFindMissing()
    {
        $product = $this->productService->find(0);
        $this->assertEquals(null, $product);
    }

    public function testFindNotActive()
    {
        $this->product->setIsActive(false);
        $id = $this->product->getId();

        $product = $this->productService->find($id);
        $this->assertEquals(null, $product);
    }

    public function testFind()
    {
        $id = $this->product->getId();

        $product = $this->productService->find($id);
        $this->assertEquals('TST101', $product->sku);
    }

    public function testFindWithCatalogPromotion()
    {
        $catalogPromotion = new Entity\CatalogPromotion;
        $catalogPromotion->setName('20% Off');
        $catalogPromotion->setCode('20PCT');
        $catalogPromotion->setDiscountType('percent');
        $catalogPromotion->setValue(20);
        $catalogPromotion->setRedemptions(0);
        $catalogPromotion->setFlagFreeShipping(false);
        $catalogPromotion->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $catalogPromotion->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));

        $this->entityManager->persist($catalogPromotion);
        $this->entityManager->flush();

        $pricing = new Pricing(new \DateTime('2014-02-01', new \DateTimeZone('UTC')));
        $pricing->loadCatalogPromotions($this->entityManager);

        $productService = new Product($this->entityManager, $pricing);

        $id = $this->product->getId();
        $product = $productService->find($id);

        $this->assertEquals(800, $product->price->unitPrice);
        $this->assertEquals(20, $product->price->catalogPromotions[0]->value);
    }

    public function testFindWithProductQuantityDiscounts()
    {
        $id = $this->product->getId();

        $productQuantityDiscount = new Entity\ProductQuantityDiscount;
        $productQuantityDiscount->setCustomerGroup(null);
        $productQuantityDiscount->setDiscountType('exact');
        $productQuantityDiscount->setQuantity(6);
        $productQuantityDiscount->setValue(500);
        $productQuantityDiscount->setFlagApplyCatalogPromotions(true);
        $productQuantityDiscount->setStart(new \DateTime('2014-01-01', new \DateTimeZone('UTC')));
        $productQuantityDiscount->setEnd(new \DateTime('2014-12-31', new \DateTimeZone('UTC')));
        $this->entityManager->persist($productQuantityDiscount);

        $this->product->addProductQuantityDiscount($productQuantityDiscount);
        $this->entityManager->flush();

        $product = $this->productService->find($id);
        $this->assertEquals(500, $product->productQuantityDiscounts[0]->value);
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

    public function testGetRelatedProducts()
    {
        $product1 = $this->getDummyProduct(1);
        $product2 = $this->getDummyProduct(2);
        $product3 = $this->getDummyProduct(3);
        $product4 = $this->getDummyProduct(4);
        $product5 = $this->getDummyProduct(5);

        $tag = new Entity\Tag;
        $tag->setName('Test Tag');
        $tag->setIsProductGroup(false);
        $tag->setIsVisible(true);

        $this->product->addTag($tag);
        $product2->addTag($tag);
        $product3->addTag($tag);
        $product4->addTag($tag);

        $this->entityManager->persist($tag);
        $this->entityManager->persist($product1);
        $this->entityManager->persist($product2);
        $this->entityManager->persist($product3);
        $this->entityManager->persist($product4);
        $this->entityManager->persist($product5);
        $this->entityManager->flush();

        $viewProduct = Entity\View\Product::factory($this->product)->withTags()->export();
        $relatedProducts = $this->productService->getRelatedProducts($viewProduct);
        $this->assertEquals(3, count($relatedProducts));
    }

    public function testGetProductsByIds()
    {
        $product1 = $this->getDummyProduct(1);
        $product2 = $this->getDummyProduct(2);
        $product3 = $this->getDummyProduct(3);
        $product4 = $this->getDummyProduct(4);
        $product5 = $this->getDummyProduct(5);

        $this->entityManager->persist($product1);
        $this->entityManager->persist($product2);
        $this->entityManager->persist($product3);
        $this->entityManager->persist($product4);
        $this->entityManager->persist($product5);
        $this->entityManager->flush();

        $productIds = [
            $product2->getId(),
            $product3->getId(),
            $product4->getId(),
        ];

        $products = $this->productService->getProductsByIds($productIds);

        $this->assertEquals(3, count($products));
        $this->assertEquals('TST2', $products[0]->sku);
        $this->assertEquals('TST3', $products[1]->sku);
        $this->assertEquals('TST4', $products[2]->sku);
    }

    public function testGetRandomProducts()
    {
        $product1 = $this->getDummyProduct(1);
        $product2 = $this->getDummyProduct(2);
        $product3 = $this->getDummyProduct(3);
        $product4 = $this->getDummyProduct(4);
        $product5 = $this->getDummyProduct(5);

        $this->entityManager->persist($product1);
        $this->entityManager->persist($product2);
        $this->entityManager->persist($product3);
        $this->entityManager->persist($product4);
        $this->entityManager->persist($product5);
        $this->entityManager->flush();

        $products = $this->productService->getRandomProducts(3);

        $this->assertEquals(3, count($products));
    }

    public function setupProductsByTag()
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

        $this->viewTag = Entity\View\Tag::factory($this->tag)->export();
    }

    public function testGetProductsByTag()
    {
        $this->setupProductsByTag();

        $products = $this->productService->getProductsByTag($this->viewTag);

        $this->assertEquals(3, count($products));
        $this->assertEquals('TST1', $products[0]->sku);
        $this->assertEquals('TST2', $products[1]->sku);
        $this->assertEquals('TST3', $products[2]->sku);
    }

    public function testGetProductsByTagPaginated()
    {
        $this->setupProductsByTag();

        $maxResults = 2;
        $page = 1;
        $pagination = new Entity\Pagination($maxResults, $page);

        $products = $this->productService->getProductsByTag($this->viewTag, $pagination);

        $this->assertEquals(3, $pagination->getTotal());
        $this->assertEquals(2, count($products));
        $this->assertEquals('TST1', $products[0]->sku);
        $this->assertEquals('TST2', $products[1]->sku);
    }

    public function testGetProductsByTagPaginatedSecondPage()
    {
        $this->setupProductsByTag();

        $maxResults = 2;
        $page = 2;
        $pagination = new Entity\Pagination($maxResults, $page);

        $products = $this->productService->getProductsByTag($this->viewTag, $pagination);

        $this->assertEquals(3, $pagination->getTotal());
        $this->assertEquals(1, count($products));
        $this->assertEquals('TST3', $products[0]->sku);
    }
}
