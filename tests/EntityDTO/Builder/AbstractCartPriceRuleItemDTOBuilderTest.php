<?php
namespace inklabs\kommerce\tests\EntityDTO\Builder;

use DateTime;
use inklabs\kommerce\Entity\AbstractCartPriceRuleItem;
use inklabs\kommerce\EntityDTO\AbstractCartPriceRuleItemDTO;
use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

abstract class AbstractCartPriceRuleItemDTOBuilderTest extends EntityDTOBuilderTestCase
{
    /**
     * @return AbstractCartPriceRuleItem
     */
    abstract protected function getItem();

    public function testBuild()
    {
        $item = $this->getItem();

        $itemDTO = $item->getDTOBuilder()
            ->build();

        $this->assertTrue($itemDTO instanceof AbstractCartPriceRuleItemDTO);
        $this->assertSame($item->getId(), $itemDTO->id);
        $this->assertSame($item->getQuantity(), $itemDTO->quantity);
        $this->assertTrue($itemDTO->created instanceof DateTime);
        $this->assertTrue($itemDTO->updated instanceof DateTime);
    }
}
