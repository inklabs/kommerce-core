<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

class CartItemTextOptionValueDTOBuilderTest extends EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $cartItemTextOptionValue = $this->dummyData->getCartItemTextOptionValue();

        $cartItemTextOptionValueDTO = $cartItemTextOptionValue->getDTOBuilder()
            ->withAllData()
            ->build();

        $this->assertTrue($cartItemTextOptionValueDTO instanceof CartItemTextOptionValueDTO);
        $this->assertTrue($cartItemTextOptionValueDTO->textOption instanceof TextOptionDTO);
    }
}
