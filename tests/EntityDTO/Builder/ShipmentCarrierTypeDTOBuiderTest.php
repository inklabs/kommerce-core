<?php
namespace inklabs\kommerce\tests\EntityDTO\Builder;

use inklabs\kommerce\Entity\ShipmentCarrierType;

class ShipmentCarrierTypeDTOBuilderTest extends AbstractIntegerTypeDTOBuilderTest
{
    /**
     * @return ShipmentCarrierType
     */
    protected function getType()
    {
        return $this->dummyData->getShipmentCarrierType();
    }

    public function testExtras()
    {
        $type = $this->getType();

        $typeDTO = $type->getDTOBuilder()
            ->build();

        $this->assertSame($type->isUnknown(), $typeDTO->isUnknown);
        $this->assertSame($type->isUps(), $typeDTO->isUps);
        $this->assertSame($type->isUsps(), $typeDTO->isUsps);
        $this->assertSame($type->isFedex(), $typeDTO->isFedex);
    }
}
