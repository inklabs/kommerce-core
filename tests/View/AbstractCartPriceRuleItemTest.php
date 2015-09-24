<?php
namespace inklabs\kommerce\View;

class AbstractCartPriceRuleItemTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $mockEntity = $this->getMockForAbstractClass('inklabs\kommerce\Entity\AbstractCartPriceRuleItem');

        $mock = $this->getMockForAbstractClass('inklabs\kommerce\View\AbstractCartPriceRuleItem', [$mockEntity])
            ->export();

        $this->assertTrue($mock instanceof AbstractCartPriceRuleItem);
    }
}
