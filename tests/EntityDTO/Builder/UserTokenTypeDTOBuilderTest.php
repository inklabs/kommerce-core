<?php
namespace inklabs\kommerce\tests\EntityDTO\Builder;

class UserTokenTypeDTOBuilderTest extends AbstractIntegerTypeDTOBuilderTest
{
    protected function getType()
    {
        return $this->dummyData->getUserTokenType();
    }
}
