<?php
namespace inklabs\kommerce\tests\EntityDTO\Builder;

use inklabs\kommerce\Entity\OptionType;
use inklabs\kommerce\EntityDTO\OptionTypeDTO;

class OptionTypeDTOBuilderTest extends AbstractIntegerTypeDTOBuilderTest
{
    /**
     * @return OptionType
     */
    protected function getType()
    {
        return $this->dummyData->getOptionType();
    }

    /**
     * @return OptionTypeDTO
     */
    protected function getTypeDTO()
    {
        return $this->getDTOBuilderFactory()
            ->getOptionTypeDTOBuilder($this->getType())
            ->build();
    }

    public function testExtras()
    {
        $type = $this->getType();
        $typeDTO = $this->getTypeDTO();

        $this->assertSame($type->isSelect(), $typeDTO->isSelect);
        $this->assertSame($type->isRadio(), $typeDTO->isRadio);
        $this->assertSame($type->isCheckbox(), $typeDTO->isCheckbox);
    }
}
