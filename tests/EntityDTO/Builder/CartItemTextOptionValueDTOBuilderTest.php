<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\EntityDTO\CartItemTextOptionValueDTO;
use inklabs\kommerce\EntityDTO\TextOptionDTO;
use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

class CartItemTextOptionValueDTOBuilderTest extends EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $cartItemTextOptionValue = $this->dummyData->getCartItemTextOptionValue();

        $cartItemTextOptionValueDTO = $this->getDTOBuilderFactory()
            ->getCartItemTextOptionValueDTOBuilder($cartItemTextOptionValue)
            ->withAllData()
            ->build();

        $this->assertTrue($cartItemTextOptionValueDTO instanceof CartItemTextOptionValueDTO);
        $this->assertTrue($cartItemTextOptionValueDTO->textOption instanceof TextOptionDTO);
    }
}
