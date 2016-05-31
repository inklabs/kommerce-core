<?php
namespace inklabs\kommerce\tests\EntityDTO\Builder;

use inklabs\kommerce\Entity\ShipmentCarrierType;
use inklabs\kommerce\EntityDTO\ShipmentCarrierTypeDTO;

class ShipmentCarrierTypeDTOBuilderTest extends AbstractIntegerTypeDTOBuilderTest
{
    /**
     * @return ShipmentCarrierType
     */
    protected function getType()
    {
        return $this->dummyData->getShipmentCarrierType();
    }

    /**
     * @return ShipmentCarrierTypeDTO
     */
    protected function getTypeDTO()
    {
        return $this->getDTOBuilderFactory()
            ->getShipmentCarrierTypeDTOBuilder($this->getType())
            ->build();
    }

    public function testExtras()
    {
        $type = $this->getType();
        $typeDTO = $this->getTypeDTO();

        $this->assertSame($type->isUnknown(), $typeDTO->isUnknown);
        $this->assertSame($type->isUps(), $typeDTO->isUps);
        $this->assertSame($type->isUsps(), $typeDTO->isUsps);
        $this->assertSame($type->isFedex(), $typeDTO->isFedex);
    }
}
