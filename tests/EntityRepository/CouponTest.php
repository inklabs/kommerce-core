<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity as Entity;
use inklabs\kommerce\tests\Helper as Helper;

class CouponTest extends Helper\DoctrineTestCase
{
    /**
     * @return Coupon
     */
    private function getRepository()
    {
        return $this->entityManager->getRepository('kommerce:Coupon');
    }

    public function setUp()
    {
        $coupon = new Entity\Coupon;
        $coupon->setName('20% OFF');
        $coupon->setCode('20PCT');
        $coupon->setType('percent');
        $coupon->setValue(20);

        $this->entityManager->persist($coupon);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function testFind()
    {
        /* @var Entity\Coupon $coupon */
        $coupon = $this->getRepository()
            ->find(1);

        $this->assertSame(1, $coupon->getId());
    }
}
