<?php
namespace inklabs\kommerce\View;

use inklabs\kommerce\Entity;

class PromotionTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityPromotion = $this->getMockForAbstractClass('inklabs\kommerce\Entity\Promotion');

        $mock = $this->getMockForAbstractClass('inklabs\kommerce\View\Promotion', [$entityPromotion])
            ->export();

        $this->assertTrue($mock instanceof Promotion);
    }
}
