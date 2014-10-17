<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity as Entity;

class ProductTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $kommerce = Kommerce::getInstance();
        $kommerce->setup([
            'driver'   => 'pdo_sqlite',
            'memory'   => true,
            // 'driver'   => 'pdo_mysql',
            // 'host'     => '127.0.0.1',
            // 'user'     => 'root',
            // 'password' => '',
            // 'dbname'   => 'birdiesperch',
        ]);

        $entityManager = $kommerce->getEntityManager();
        $entityManager->clear();

        $tool = new \Doctrine\ORM\Tools\SchemaTool($entityManager);
        $classes = $entityManager->getMetaDataFactory()->getAllMetaData();

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

        $entityManager->persist($this->product);
        $entityManager->flush();
    }

    public function testFindMissing()
    {
        $product = Product::find(0);
        $this->assertEquals(null, $product);
    }

    public function testFindNotActive()
    {
        $this->product->setIsActive(false);
        $id = $this->product->getId();
        $product = Product::find($id);
        $this->assertEquals(null, $product);
    }

    public function testFind()
    {
        $id = $this->product->getId();
        $product = Product::find($id);
        $this->assertEquals($this->product, $product);
    }
}
