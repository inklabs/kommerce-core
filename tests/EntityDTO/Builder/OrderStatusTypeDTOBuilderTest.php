<?php
namespace inklabs\kommerce\tests\EntityDTO\Builder;

use inklabs\kommerce\Entity\OrderStatusType;

class OrderStatusTypeDTOBuilderTest extends AbstractIntegerTypeDTOBuilderTest
{
    /**
     * @return OrderStatusType
     */
    protected function getType()
    {
        return $this->dummyData->getOrderStatusType();
    }

    public function testExtras()
    {
        $type = $this->getType();

        $typeDTO = $type->getDTOBuilder()
            ->build();

        $this->assertSame($type->isPending(), $typeDTO->isPending);
        $this->assertSame($type->isProcessing(), $typeDTO->isProcessing);
        $this->assertSame($type->isPartiallyShipped(), $typeDTO->isPartiallyShipped);
        $this->assertSame($type->isShipped(), $typeDTO->isShipped);
        $this->assertSame($type->isComplete(), $typeDTO->isComplete);
        $this->assertSame($type->isCanceled(), $typeDTO->isCanceled);
    }
}
