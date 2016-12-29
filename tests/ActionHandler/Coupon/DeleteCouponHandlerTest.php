<?php
namespace inklabs\kommerce\ActionHandler\Coupon;

use inklabs\kommerce\Action\Coupon\DeleteCouponCommand;
use inklabs\kommerce\Entity\Coupon;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\tests\Helper\TestCase\ActionTestCase;

class DeleteCouponHandlerTest extends ActionTestCase
{
    protected $metaDataClassNames = [
        Coupon::class,
    ];

    public function testHandle()
    {
        $coupon = $this->dummyData->getCoupon();
        $this->persistEntityAndFlushClear($coupon);

        $command = new DeleteCouponCommand($coupon->getId()->getHex());
        $this->dispatchCommand($command);

        $this->entityManager->clear();

        $this->expectException(EntityNotFoundException::class);
        $this->getRepositoryFactory()->getCouponRepository()->findOneById(
            $command->getCouponId()
        );
    }
}
