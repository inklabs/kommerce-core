<?php
namespace inklabs\kommerce\tests\EntityDTO\Builder;

use inklabs\kommerce\Entity\OrderStatusType;
use inklabs\kommerce\EntityDTO\OrderStatusTypeDTO;

class OrderStatusTypeDTOBuilderTest extends AbstractIntegerTypeDTOBuilderTest
{
    /**
     * @return OrderStatusType
     */
    protected function getType()
    {
        return $this->dummyData->getOrderStatusType();
    }

    /**
     * @return OrderStatusTypeDTO
     */
    protected function getTypeDTO()
    {
        return $this->getDTOBuilderFactory()
            ->getOrderStatusTypeDTOBuilder($this->getType())
            ->build();
    }

    public function testExtras()
    {
        $type = $this->getType();
        $typeDTO = $this->getTypeDTO();

        $this->assertSame($type->isPending(), $typeDTO->isPending);
        $this->assertSame($type->isProcessing(), $typeDTO->isProcessing);
        $this->assertSame($type->isPartiallyShipped(), $typeDTO->isPartiallyShipped);
        $this->assertSame($type->isShipped(), $typeDTO->isShipped);
        $this->assertSame($type->isComplete(), $typeDTO->isComplete);
        $this->assertSame($type->isCanceled(), $typeDTO->isCanceled);
    }
}
