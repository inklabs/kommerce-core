<?php
namespace inklabs\kommerce\tests\EntityDTO\Builder;

use inklabs\kommerce\Entity\TextOptionType;
use inklabs\kommerce\EntityDTO\TextOptionTypeDTO;

class TextOptionTypeDTOBuilderTest extends AbstractIntegerTypeDTOBuilderTest
{
    /**
     * @return TextOptionType
     */
    protected function getType()
    {
        return $this->dummyData->getTextOptionType();
    }

    /**
     * @return TextOptionTypeDTO
     */
    protected function getTypeDTO()
    {
        return $this->getDTOBuilderFactory()
            ->getTextOptionTypeDTOBuilder($this->getType())
            ->build();
    }

    public function testExtras()
    {
        $type = $this->getType();
        $typeDTO = $this->getTypeDTO();

        $this->assertSame($type->isText(), $typeDTO->isText);
        $this->assertSame($type->isTextarea(), $typeDTO->isTextarea);
        $this->assertSame($type->isFile(), $typeDTO->isFile);
        $this->assertSame($type->isDate(), $typeDTO->isDate);
        $this->assertSame($type->isTime(), $typeDTO->isTime);
        $this->assertSame($type->isDateTime(), $typeDTO->isDateTime);
    }
}
