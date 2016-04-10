<?php
namespace inklabs\kommerce\tests\EntityDTO\Builder;

use inklabs\kommerce\Entity\UserLoginResultType;

class UserLoginResultTypeDTOBuilderTest extends AbstractIntegerTypeDTOBuilderTest
{
    /**
     * @return UserLoginResultType
     */
    protected function getType()
    {
        return $this->dummyData->getUserLoginResultType();
    }

    public function testExtras()
    {
        $type = $this->getType();

        $typeDTO = $type->getDTOBuilder()
            ->build();

        $this->assertSame($type->isFail(), $typeDTO->isFail);
        $this->assertSame($type->isSuccess(), $typeDTO->isSuccess);
    }
}
