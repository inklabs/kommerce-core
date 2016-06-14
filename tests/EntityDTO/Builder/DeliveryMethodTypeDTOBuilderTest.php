<?php
namespace inklabs\kommerce\tests\EntityDTO\Builder;

use inklabs\kommerce\Entity\DeliveryMethodType;
use inklabs\kommerce\EntityDTO\DeliveryMethodTypeDTO;

class DeliveryMethodTypeDTOBuilderTest extends AbstractIntegerTypeDTOBuilderTest
{
    /**
     * @return DeliveryMethodType
     */
    protected function getType()
    {
        return $this->dummyData->getDeliveryMethodType();
    }

    /**
     * @return DeliveryMethodTypeDTO
     */
    protected function getTypeDTO()
    {
        return $this->getDTOBuilderFactory()
            ->getDeliveryMethodTypeDTOBuilder($this->getType())
            ->build();
    }

    public function testExtras()
    {
        $type = $this->getType();
        $typeDTO = $this->getTypeDTO();

        $this->assertSame($type->isStandard(), $typeDTO->isStandard);
        $this->assertSame($type->isOneDay(), $typeDTO->isOneDay);
        $this->assertSame($type->isTwoDay(), $typeDTO->isTwoDay);
    }
}
