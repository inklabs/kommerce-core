<?php
namespace inklabs\kommerce\Entity\View;

use inklabs\kommerce\Entity as Entity;

class PromotionTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $entityPromotion = new Entity\Promotion;

        $mock = $this->getMockForAbstractClass('inklabs\kommerce\Entity\View\Promotion', [$entityPromotion])
            ->export();

        $this->assertTrue($mock instanceof Promotion);
    }
}
