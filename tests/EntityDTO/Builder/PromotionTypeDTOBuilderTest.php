<?php
namespace inklabs\kommerce\tests\EntityDTO\Builder;

use inklabs\kommerce\Entity\PromotionType;

class PromotionTypeDTOBuilderTest extends AbstractIntegerTypeDTOBuilderTest
{
    /**
     * @return PromotionType
     */
    protected function getType()
    {
        return $this->dummyData->getPromotionType();
    }

    public function testExtras()
    {
        $type = $this->getType();

        $typeDTO = $type->getDTOBuilder()
            ->build();

        $this->assertSame($type->isFixed(), $typeDTO->isFixed);
        $this->assertSame($type->isPercent(), $typeDTO->isPercent);
        $this->assertSame($type->isExact(), $typeDTO->isExact);
    }
}
