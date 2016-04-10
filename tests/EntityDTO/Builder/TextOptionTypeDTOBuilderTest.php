<?php
namespace inklabs\kommerce\tests\EntityDTO\Builder;

use inklabs\kommerce\Entity\TextOptionType;

class TextOptionTypeDTOBuilderTest extends AbstractIntegerTypeDTOBuilderTest
{
    /**
     * @return TextOptionType
     */
    protected function getType()
    {
        return $this->dummyData->getTextOptionType();
    }

    public function testExtras()
    {
        $type = $this->getType();

        $typeDTO = $type->getDTOBuilder()
            ->build();

        $this->assertSame($type->isText(), $typeDTO->isText);
        $this->assertSame($type->isTextarea(), $typeDTO->isTextarea);
        $this->assertSame($type->isFile(), $typeDTO->isFile);
        $this->assertSame($type->isDate(), $typeDTO->isDate);
        $this->assertSame($type->isTime(), $typeDTO->isTime);
        $this->assertSame($type->isDateTime(), $typeDTO->isDateTime);
    }
}
