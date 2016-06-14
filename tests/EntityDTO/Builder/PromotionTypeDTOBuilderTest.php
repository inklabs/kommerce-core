<?php
namespace inklabs\kommerce\tests\EntityDTO\Builder;

use inklabs\kommerce\Entity\PromotionType;
use inklabs\kommerce\EntityDTO\PromotionTypeDTO;

class PromotionTypeDTOBuilderTest extends AbstractIntegerTypeDTOBuilderTest
{
    /**
     * @return PromotionType
     */
    protected function getType()
    {
        return $this->dummyData->getPromotionType();
    }

    /**
     * @return PromotionTypeDTO
     */
    protected function getTypeDTO()
    {
        return $this->getDTOBuilderFactory()
            ->getPromotionTypeDTOBuilder($this->getType())
            ->build();
    }

    public function testExtras()
    {
        $type = $this->getType();
        $typeDTO = $this->getTypeDTO();

        $this->assertSame($type->isFixed(), $typeDTO->isFixed);
        $this->assertSame($type->isPercent(), $typeDTO->isPercent);
        $this->assertSame($type->isExact(), $typeDTO->isExact);
    }
}
