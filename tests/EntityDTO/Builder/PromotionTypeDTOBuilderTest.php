<?php
namespace inklabs\kommerce\tests\EntityDTO\Builder;

class PromotionTypeDTOBuilderTest extends AbstractIntegerTypeDTOBuilderTest
{
    protected function getType()
    {
        return $this->dummyData->getPromotionType();
    }
}
