<?php
namespace inklabs\kommerce\EntityDTO\Builder;

use inklabs\kommerce\Exception\DTOBuilderException;
use inklabs\kommerce\tests\Helper\Entity\FakeCartPriceRuleItem;
use inklabs\kommerce\tests\Helper\Entity\FakePayment;
use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

class DTOBuilderFactoryTest extends EntityDTOBuilderTestCase
{
    public function testInvalidCartPriceRuleItemThrowsException()
    {
        $dtoBuilderFactory = new DTOBuilderFactory();

        $this->setExpectedException(
            DTOBuilderException::class,
            'Invalid CartPriceRuleItem'
        );

        $dtoBuilderFactory->getCartPriceRuleItemDTOBuilder(new FakeCartPriceRuleItem());
    }

    public function testInvalidPaymentThrowsException()
    {
        $dtoBuilderFactory = new DTOBuilderFactory();

        $this->setExpectedException(
            DTOBuilderException::class,
            'Invalid payment'
        );

        $dtoBuilderFactory->getPaymentDTOBuilder(new FakePayment());
    }
}
