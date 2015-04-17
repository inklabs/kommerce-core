<?php
namespace inklabs\kommerce\View\CartPriceRuleItem;

use inklabs\kommerce\Entity;

class ItemTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $mockEntity = $this->getMockForAbstractClass('inklabs\kommerce\Entity\CartPriceRuleItem\Item');

        $mock = $this->getMockForAbstractClass('inklabs\kommerce\View\CartPriceRuleItem\Item', [$mockEntity])
            ->export();

        $this->assertTrue($mock instanceof Item);
    }
}
