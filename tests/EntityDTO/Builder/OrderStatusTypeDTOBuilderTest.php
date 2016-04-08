<?php
namespace inklabs\kommerce\tests\EntityDTO\Builder;

class OrderStatusTypeDTOBuilderTest extends AbstractIntegerTypeDTOBuilderTest
{
    protected function getType()
    {
        return $this->dummyData->getOrderStatusType();
    }
}
