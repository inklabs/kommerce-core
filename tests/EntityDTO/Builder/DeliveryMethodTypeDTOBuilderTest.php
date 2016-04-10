<?php
namespace inklabs\kommerce\tests\EntityDTO\Builder;

use inklabs\kommerce\Entity\DeliveryMethodType;

class DeliveryMethodTypeDTOBuilderTest extends AbstractIntegerTypeDTOBuilderTest
{
    /**
     * @return DeliveryMethodType
     */
    protected function getType()
    {
        return $this->dummyData->getDeliveryMethodType();
    }

    public function testExtras()
    {
        $type = $this->getType();

        $typeDTO = $type->getDTOBuilder()
            ->build();

        $this->assertSame($type->isStandard(), $typeDTO->isStandard);
        $this->assertSame($type->isOneDay(), $typeDTO->isOneDay);
        $this->assertSame($type->isTwoDay(), $typeDTO->isTwoDay);
    }
}
