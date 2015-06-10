<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;

class PromotionTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityPromotion = $this->getMockForAbstractClass('inklabs\kommerce\Entity\Promotion');
        $entityPromotion->setStart(new \DateTime);
        $entityPromotion->setEnd(new \DateTime);


        $promotion = $this->getMockForAbstractClass('inklabs\kommerce\View\Promotion', [$entityPromotion])
            ->export();

        $this->assertTrue($promotion instanceof Promotion);
    }
}
