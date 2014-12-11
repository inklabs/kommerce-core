<?php
namespace inklabs\kommerce\Doctrine\ORM;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\tests\Helper as Helper;
use inklabs\kommerce\Lib\BaseConvert;

class EntityRepositoryTest extends Helper\DoctrineTestCase
{
    /* @var Entity\Product */
    protected $product;

    public function setUp()
    {
        $this->product = new Entity\Product;
        $this->product->setSku('TST101');
        $this->product->setName('Test Product');
        $this->product->setDescription('Test product description');
        $this->product->setUnitPrice(500);
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

    public function testFindByEncodedId()
    {
        // TODO
//        $id = $this->product->getId();
//        $encodedId = BaseConvert::encode($id);
//
//        $stub = new EntityRepository();
//
//        $this->assertEquals($id, $stub->findByEncodedId($encodedId));
    }
}
