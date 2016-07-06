<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity\Attribute;
use inklabs\kommerce\Entity\AttributeValue;
use inklabs\kommerce\Entity\Image;
use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\OptionProduct;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\ProductAttribute;
use inklabs\kommerce\Entity\ProductQuantityDiscount;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\tests\Helper\TestCase\EntityRepositoryTestCase;

class ProductRepositoryTest extends EntityRepositoryTestCase
{
    protected $metaDataClassNames = [
        Attribute::class,
        AttributeValue::class,
        Product::class,
        ProductQuantityDiscount::class,
        ProductAttribute::class,
        Image::class,
        Tag::class,
        Option::class,
        OptionProduct::class,
    ];

    /** @var ProductRepository */
    protected $productRepository;

    public function setUp()
    {
        parent::setUp();
        $this->productRepository = $this->getRepositoryFactory()->getProductRepository();
    }

    private function setupProduct()
    {
        $product = $this->dummyData->getProduct();

        $this->entityManager->persist($product);
        $this->entityManager->flush();
        $this->entityManager->clear();

        return $product;
    }

    public function testCRUD()
    {
        $this->executeRepositoryCRUD(
            $this->productRepository,
            $this->dummyData->getProduct()
        );
    }

    public function testFindOneById()
    {
        $tag = $this->dummyData->getTag();
        $image = $this->dummyData->getImage();

        $sku = 'TST101';
        $name = 'Test Product';
        $description = 'Test description';
        $defaultImage = 'http://lorempixel.com/400/200/';
        $unitPrice = 500;
        $quantity = 10;
        $shippingWeight = 16;
        $rating = 500;

        $originalProduct = new Product;
        $originalProduct->setSku($sku);
        $originalProduct->setName($name);
        $originalProduct->setDescription($description);
        $originalProduct->setDefaultImage($defaultImage);
        $originalProduct->setUnitPrice($unitPrice);
        $originalProduct->setQuantity($quantity);
        $originalProduct->setShippingWeight($shippingWeight);
        $originalProduct->setRating($rating);
        $originalProduct->setIsInventoryRequired(true);
        $originalProduct->setIsPriceVisible(true);
        $originalProduct->setIsActive(true);
        $originalProduct->setIsVisible(true);
        $originalProduct->setIsTaxable(true);
        $originalProduct->setIsShippable(true);
        $originalProduct->enableAttachments();
        $originalProduct->addTag($tag);
        $originalProduct->addImage($image);

        $attribute = $this->dummyData->getAttribute();
        $attributeValue = $this->dummyData->getAttributeValue($attribute);
        $productAttribute = $this->dummyData->getProductAttribute($originalProduct, $attribute, $attributeValue);
        $option = $this->dummyData->getOption();
        $optionProduct = $this->dummyData->getOptionProduct($option, $originalProduct);
        $productQuantityDiscount = $this->dummyData->getProductQuantityDiscount($originalProduct);

        $this->persistEntityAndFlushClear([
            $tag,
            $image,
            $option,
            $optionProduct,
            $attribute,
            $attributeValue,
            $originalProduct,
        ]);

        $this->setCountLogger();

        $product = $this->productRepository->findOneById(
            $originalProduct->getId()
        );

        $this->assertEquals($originalProduct->getId(), $product->getId());
        $this->assertSame($sku, $product->getSku());
        $this->assertSame($name, $product->getName());
        $this->assertSame($description, $product->getDescription());
        $this->assertSame($defaultImage, $product->getDefaultImage());
        $this->assertSame($unitPrice, $product->getUnitPrice());
        $this->assertSame($quantity, $product->getQuantity());
        $this->assertSame($shippingWeight, $product->getShippingWeight());
        $this->assertSame(5, $product->getRating());
        $this->assertTrue($product->isInventoryRequired());
        $this->assertTrue($product->isPriceVisible());
        $this->assertTrue($product->isActive());
        $this->assertTrue($product->isvisible());
        $this->assertTrue($product->isTaxable());
        $this->assertTrue($product->isShippable());
        $this->assertTrue($product->areAttachmentsEnabled());
        $this->assertEquals($tag->getId(), $product->getTags()[0]->getId());
        $this->assertEquals($image->getId(), $product->getImages()[0]->getId());
        $this->assertEquals($productQuantityDiscount->getId(), $product->getProductQuantityDiscounts()[0]->getId());
        $this->assertEquals($optionProduct->getId(), $product->getOptionProducts()[0]->getId());
        $this->assertEquals($productAttribute->getId(), $product->getProductAttributes()[0]->getId());
        $this->assertSame(6, $this->getTotalQueries());
    }

    public function testFindOneByIdThrowsException()
    {
        $this->setExpectedException(
            EntityNotFoundException::class,
            'Product not found'
        );

        $this->productRepository->findOneById(
            $this->dummyData->getId()
        );
    }

    public function testGetRelatedProducts()
    {
        $product1 = $this->dummyData->getProduct();
        $product2 = $this->dummyData->getProduct();
        $product3 = $this->dummyData->getProduct();

        $tag = new Tag;
        $tag->setName('Test Tag');
        $tag->setIsVisible(true);

        $product1->addTag($tag);
        $product2->addTag($tag);

        $this->entityManager->persist($tag);
        $this->entityManager->persist($product1);
        $this->entityManager->persist($product2);
        $this->entityManager->persist($product3);
        $this->entityManager->flush();
        $this->entityManager->clear();

        $products = $this->productRepository->getRelatedProductsByIds([$product1->getId()]);

        $this->assertSame(1, count($products));
        $this->assertEntitiesEqual($product2, $products[0]);
    }

    public function testGetProductsByTagId()
    {
        $product1 = $this->dummyData->getProduct();
        $product2 = $this->dummyData->getProduct();
        $product3 = $this->dummyData->getProduct();
        $tag = $this->dummyData->getTag();
        $tag->addProduct($product1);
        $tag->addProduct($product2);

        $this->entityManager->persist($tag);
        $this->entityManager->persist($product1);
        $this->entityManager->persist($product2);
        $this->entityManager->persist($product3);
        $this->entityManager->flush();
        $this->entityManager->clear();

        $this->setCountLogger();

        $products = $this->productRepository->getProductsByTagId(
            $tag->getId()
        );

        foreach ($products as $product) {
            $this->visitElements($product->getTags());
        }

        $this->assertSame(2, count($products));
        $this->assertEntityInArray($product1, $products);
        $this->assertEntityInArray($product2, $products);
        $this->assertSame(2, $this->getTotalQueries());
    }

    public function testGetProductsByIds()
    {
        $product1 = $this->setupProduct();
        $product2 = $this->setupProduct();

        $this->setCountLogger();

        $products = $this->productRepository->getProductsByIds([
            $product1->getId(),
            $product2->getId()
        ]);

        foreach ($products as $product) {
            $this->visitElements($product->getTags());
        }

        $this->assertSame(2, count($products));
        $this->assertSame(2, $this->getTotalQueries());
    }

    public function testGetAllProducts()
    {
        $originalProduct = $this->setupProduct();

        $products = $this->productRepository->getAllProducts(
            $originalProduct->getName()
        );

        $this->assertEquals($originalProduct->getId(), $products[0]->getId());
    }

    public function testGetAllProductsByIds()
    {
        $originalProduct = $this->setupProduct();

        $products = $this->productRepository->getAllProductsByIds([
            $originalProduct->getId()
        ]);

        $this->assertEquals($originalProduct->getId(), $products[0]->getId());
    }

    public function testGetRandomProducts()
    {
        $product1 = $this->dummyData->getProduct();
        $product2 = $this->dummyData->getProduct();
        $product3 = $this->dummyData->getProduct();

        $this->entityManager->persist($product1);
        $this->entityManager->persist($product2);
        $this->entityManager->persist($product3);
        $this->entityManager->flush();
        $this->entityManager->clear();

        $products = $this->productRepository->getRandomProducts(2);

        $this->assertSame(2, count($products));
    }
}
