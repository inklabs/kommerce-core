<?php
namespace inklabs\kommerce\tests\EntityDTO\Builder;

use inklabs\kommerce\Entity\OptionType;

class OptionTypeDTOBuilderTest extends AbstractIntegerTypeDTOBuilderTest
{
    /**
     * @return OptionType
     */
    protected function getType()
    {
        return $this->dummyData->getOptionType();
    }

    public function testExtras()
    {
        $type = $this->getType();

        $typeDTO = $type->getDTOBuilder()
            ->build();

        $this->assertSame($type->isSelect(), $typeDTO->isSelect);
        $this->assertSame($type->isRadio(), $typeDTO->isRadio);
        $this->assertSame($type->isCheckbox(), $typeDTO->isCheckbox);
    }
}
