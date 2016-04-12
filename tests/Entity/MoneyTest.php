<?php
namespace inklabs\kommerce\tests\Entity;

use inklabs\kommerce\Entity\Money;
use inklabs\kommerce\EntityDTO\Builder\MoneyDTOBuilder;
use inklabs\kommerce\tests\Helper\TestCase\EntityTestCase;

class MoneyTest extends EntityTestCase
{
    public function testCreate()
    {
        $money = new Money(1000, 'USD');

        $this->assertEntityValid($money);
        $this->assertSame(1000, $money->getAmount());
        $this->assertSame('USD', $money->getCurrency());
        $this->assertTrue($money->getDTOBuilder() instanceof MoneyDTOBuilder);
    }
}
