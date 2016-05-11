<?php
namespace inklabs\kommerce\EntityRepository;

use DateTime;
use Exception;
use inklabs\kommerce\Entity\Attribute;
use inklabs\kommerce\Entity\AttributeValue;
use inklabs\kommerce\Entity\Image;
use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\OptionProduct;
use inklabs\kommerce\Entity\Pagination;
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

    /** @var ProductRepositoryInterface */
    protected $productRepository;

    public function setUp()
    {
        parent::setUp();
        $this->productRepository = $this->getRepositoryFactory()->getProductRepository();
    }

    private function setupProduct($num = 1)
    {
        $product = $this->dummyData->getProduct($num);

        $this->entityManager->persist($product);
        $this->entityManager->flush();
        $this->entityManager->clear();

        return $product;
    }

    public function testCRUD()
    {
        $product = $this->dummyData->getProduct();
        $this->productRepository->create($product);
        $this->assertSame(1, $product->getId());

        $product->setName('new name');
        $this->assertSame(null, $product->getUpdated());
        $this->productRepository->update($product);
        $this->assertTrue($product->getUpdated() instanceof DateTime);

        $productQuantityDiscount = $this->dummyData->getProductQuantityDiscount($product);

        $this->productRepository->update($product);
        $this->assertTrue($product->getUpdated() instanceof DateTime);
        $this->assertTrue($product->getProductQuantityDiscounts()[0]->getCreated() instanceof DateTime);

        $product->removeProductQuantityDiscount($product->getProductQuantityDiscounts()[0]);
        $this->productRepository->update($product);
        $this->assertTrue($product->getUpdated() instanceof DateTime);

        try {
            $this->getRepositoryFactory()->getProductQuantityDiscountRepository()->findOneById(1);
            $this->fail();
        } catch (Exception $e) {
            $this->assertTrue(true);
        }

        $this->productRepository->delete($product);
        $this->assertSame(null, $product->getId());
    }

    public function testUpdateThrowsExceptionWhenNotFound()
    {
        $this->setExpectedException(
            EntityNotFoundException::class,
            'Product not found'
        );

        $this->productRepository->update(new Product);
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

        $product = new Product;
        $product->setSku($sku);
        $product->setName($name);
        $product->setDescription($description);
        $product->setDefaultImage($defaultImage);
        $product->setUnitPrice($unitPrice);
        $product->setQuantity($quantity);
        $product->setShippingWeight($shippingWeight);
        $product->setRating($rating);
        $product->setIsInventoryRequired(true);
        $product->setIsPriceVisible(true);
        $product->setIsActive(true);
        $product->setIsVisible(true);
        $product->setIsTaxable(true);
        $product->setIsShippable(true);
        $product->enableAttachments();
        $product->addTag($tag);
        $product->addImage($image);

        $attribute = $this->dummyData->getAttribute();
        $attributeValue = $this->dummyData->getAttributeValue($attribute);
        $productAttribute = $this->dummyData->getProductAttribute($product, $attribute, $attributeValue);
        $option = $this->dummyData->getOption();
        $optionProduct = $this->dummyData->getOptionProduct($option, $product);
        $productQuantityDiscount = $this->dummyData->getProductQuantityDiscount($product);

        $this->persistEntityAndFlushClear([
            $tag,
            $image,
            $option,
            $optionProduct,
            $attribute,
            $attributeValue,
            $product,
        ]);

        $this->setCountLogger();

        $product = $this->productRepository->findOneById($product->getId());

        $this->assertTrue($product instanceof Product);
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
        $this->assertSame($tag->getId(), $product->getTags()[0]->getId());
        $this->assertSame($image->getId(), $product->getImages()[0]->getId());
        $this->assertSame($productQuantityDiscount->getId(), $product->getProductQuantityDiscounts()[0]->getId());
        $this->assertSame($optionProduct->getId(), $product->getOptionProducts()[0]->getId());
        $this->assertSame($productAttribute->getId(), $product->getProductAttributes()[0]->getId());
        $this->assertSame(6, $this->getTotalQueries());
    }

    public function testFindOneByIdThrowsException()
    {
        $this->setExpectedException(
            EntityNotFoundException::class,
            'Product not found'
        );

        $this->productRepository->findOneById(1);
    }

    public function testGetRelatedProducts()
    {
        $product1 = $this->dummyData->getProduct(1);
        $product2 = $this->dummyData->getProduct(2);
        $product3 = $this->dummyData->getProduct(3);

        $tag = new Tag;
        $tag->setName('Test Tag');
        $tag->setIsVisible(true);

        $product1->addTag($tag);
        $product2->addTag($tag);

        $this->entityManager->persist($tag);

        $this->productRepository->create($product1);
        $this->productRepository->create($product2);
        $this->productRepository->create($product3);

        $this->entityManager->flush();
        $this->entityManager->clear();

        $products = $this->productRepository->getRelatedProducts([$product1]);

        $this->assertSame(1, count($products));
        $this->assertSame(2, $products[0]->getId());
    }

    public function testGetProductsByTag()
    {
        $tag = new Tag;
        $tag->setName('Test Tag');
        $tag->setDescription('Test Description');
        $tag->setDefaultImage('http://lorempixel.com/400/200/');
        $tag->setSortOrder(0);
        $tag->setIsVisible(true);

        $product1 = $this->dummyData->getProduct(1);
        $product2 = $this->dummyData->getProduct(2);
        $product3 = $this->dummyData->getProduct(3);

        $product1->addTag($tag);
        $product2->addTag($tag);

        $this->entityManager->persist($tag);
        $this->entityManager->persist($product1);
        $this->entityManager->persist($product2);
        $this->entityManager->persist($product3);
        $this->entityManager->flush();
        $this->entityManager->clear();

        $this->setCountLogger();

        $products = $this->productRepository->getProductsByTag($tag);

        foreach ($products as $product) {
            $product->getTags()->toArray();
        }

        $this->assertSame(2, count($products));
        $this->assertSame(1, $products[0]->getId());
        $this->assertSame(2, $products[1]->getid());
        $this->assertSame(2, $this->getTotalQueries());
    }

    public function testGetProductsByIds()
    {
        $this->setupProduct(1);
        $this->setupProduct(2);

        $this->setCountLogger();

        $products = $this->productRepository->getProductsByIds([1, 2]);

        foreach ($products as $product) {
            $product->getTags()->toArray();
        }

        $this->assertSame(2, count($products));
        $this->assertSame(2, $this->getTotalQueries());
    }

    public function testGetAllProducts()
    {
        $this->setupProduct();

        $products = $this->productRepository->getAllProducts('#1');

        $this->assertSame(1, $products[0]->getId());
    }

    public function testGetAllProductsByIds()
    {
        $this->setupProduct();

        $products = $this->productRepository->getAllProductsByIds([1]);

        $this->assertSame(1, $products[0]->getId());
    }

    public function testGetRandomProducts()
    {
        $product1 = $this->dummyData->getProduct(1);
        $product2 = $this->dummyData->getProduct(2);
        $product3 = $this->dummyData->getProduct(3);

        $this->entityManager->persist($product1);
        $this->entityManager->persist($product2);
        $this->entityManager->persist($product3);
        $this->entityManager->flush();
        $this->entityManager->clear();

        $products = $this->productRepository->getRandomProducts(2);

        $this->assertSame(2, count($products));
    }

    public function testGetProductsByTagPaginated()
    {
        $tag = new Tag;
        $tag->setName('Test Tag');
        $tag->setDescription('Test Description');
        $tag->setDefaultImage('http://lorempixel.com/400/200/');
        $tag->setSortOrder(0);
        $tag->setIsVisible(true);

        $product1 = $this->dummyData->getProduct(1);
        $product2 = $this->dummyData->getProduct(2);
        $product3 = $this->dummyData->getProduct(3);

        $product1->addTag($tag);
        $product2->addTag($tag);
        $product3->addTag($tag);

        $this->entityManager->persist($tag);

        $this->entityManager->persist($product1);
        $this->entityManager->persist($product2);
        $this->entityManager->persist($product3);
        $this->entityManager->flush();
        $this->entityManager->clear();

        $maxResults = 2;
        $page = 1;
        $pagination = new Pagination($maxResults, $page);

        $products = $this->productRepository->getProductsByTag($tag, $pagination);

        $this->assertSame(2, count($products));
        $this->assertSame(1, $products[0]->getId());
        $this->assertSame(2, $products[1]->getId());
        $this->assertSame(3, $pagination->getTotal());

        // Page 2
        $maxResults = 2;
        $page = 2;
        $pagination = new Pagination($maxResults, $page);

        $products = $this->productRepository->getProductsByTag($tag, $pagination);

        $this->assertSame(1, count($products));
        $this->assertSame(3, $products[0]->getId());
        $this->assertSame(3, $pagination->getTotal());
    }
}
