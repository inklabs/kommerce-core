<?php
namespace inklabs\kommerce\Doctrine\Functions\Sqlite;

use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\tests\Helper\TestCase\EntityRepositoryTestCase;

class RandTest extends EntityRepositoryTestCase
{
    /** @var Product */
    private $product1;

    /** @var Product */
    private $product2;

    /** @var Product */
    private $product3;

    protected $metaDataClassNames = [
        Product::class,
    ];

    public function setUp()
    {
        parent::setUp();

        $this->product1 = $this->dummyData->getProduct(1);
        $this->product2 = $this->dummyData->getProduct(2);
        $this->product3 = $this->dummyData->getProduct(3);

        $this->entityManager->persist($this->product1);
        $this->entityManager->persist($this->product2);
        $this->entityManager->persist($this->product3);
        $this->entityManager->flush();
    }

    public function testRand()
    {
        $qb = $this->entityManager->createQueryBuilder();

        $randomProducts = $qb->select('Product')
            ->from(Product::class, 'Product')
            ->addSelect('RAND() as HIDDEN rand')
            ->orderBy('rand')
            ->getQuery()
            ->getResult();

        $this->assertSame(3, count($randomProducts));
        $this->assertTrue(in_array($this->product1, $randomProducts));
        $this->assertTrue(in_array($this->product2, $randomProducts));
        $this->assertTrue(in_array($this->product3, $randomProducts));
    }

    public function testRandWithSeed()
    {
        $qb = $this->entityManager->createQueryBuilder();

        $randomProducts = $qb->select('Product')
            ->from(Product::class, 'Product')
            ->addSelect('RAND(:rand) as HIDDEN rand')
            ->orderBy('rand')
            ->setParameter('rand', $this->product1->getId())
            ->getQuery()
            ->getResult();

        $this->assertSame(3, count($randomProducts));
        $this->assertTrue(in_array($this->product1, $randomProducts));
        $this->assertTrue(in_array($this->product2, $randomProducts));
        $this->assertTrue(in_array($this->product3, $randomProducts));
    }
}
