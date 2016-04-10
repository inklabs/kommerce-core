<?php
namespace inklabs\kommerce\tests\EntityDTO\Builder;

use inklabs\kommerce\Entity\UserStatusType;

class UserStatusTypeDTOBuilderTest extends AbstractIntegerTypeDTOBuilderTest
{
    /**
     * @return UserStatusType
     */
    protected function getType()
    {
        return $this->dummyData->getUserStatusType();
    }

    public function testExtras()
    {
        $type = $this->getType();

        $typeDTO = $type->getDTOBuilder()
            ->build();

        $this->assertSame($type->isInactive(), $typeDTO->isInactive);
        $this->assertSame($type->isActive(), $typeDTO->isActive);
        $this->assertSame($type->isLocked(), $typeDTO->isLocked);
    }
}
