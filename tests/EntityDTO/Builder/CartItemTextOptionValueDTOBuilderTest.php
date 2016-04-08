<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\DoctrineTestCase;

class CartItemTextOptionValueDTOBuilderTest extends DoctrineTestCase
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
