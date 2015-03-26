<?php
namespace inklabs\kommerce\Doctrine\Functions\Sqlite;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\tests\Helper as Helper;

class RandTest extends Helper\DoctrineTestCase
{
    /** @var Entity\Product */
    private $product1;

    /** @var Entity\Product */
    private $product2;

    /** @var Entity\Product */
    private $product3;

    public function setUp()
    {
        $this->product1 = $this->getDummyProduct(1);
        $this->product2 = $this->getDummyProduct(2);
        $this->product3 = $this->getDummyProduct(3);

        $this->entityManager->persist($this->product1);
        $this->entityManager->persist($this->product2);
        $this->entityManager->persist($this->product3);
        $this->entityManager->flush();
    }

    public function testRand()
    {
        $qb = $this->entityManager->createQueryBuilder();

        $randomProducts = $qb->select('product')
            ->from('inklabs\kommerce\Entity\Product', 'product')
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

        $randomProducts = $qb->select('product')
            ->from('inklabs\kommerce\Entity\Product', 'product')
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
