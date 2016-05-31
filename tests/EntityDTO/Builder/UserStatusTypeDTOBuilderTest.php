<?php
namespace inklabs\kommerce\tests\EntityDTO\Builder;

use inklabs\kommerce\Entity\UserStatusType;
use inklabs\kommerce\EntityDTO\UserStatusTypeDTO;

class UserStatusTypeDTOBuilderTest extends AbstractIntegerTypeDTOBuilderTest
{
    /**
     * @return UserStatusType
     */
    protected function getType()
    {
        return $this->dummyData->getUserStatusType();
    }

    /**
     * @return UserStatusTypeDTO
     */
    protected function getTypeDTO()
    {
        return $this->getDTOBuilderFactory()
            ->getUserStatusTypeDTOBuilder($this->getType())
            ->build();
    }

    public function testExtras()
    {
        $type = $this->getType();
        $typeDTO = $this->getTypeDTO();

        $this->assertSame($type->isInactive(), $typeDTO->isInactive);
        $this->assertSame($type->isActive(), $typeDTO->isActive);
        $this->assertSame($type->isLocked(), $typeDTO->isLocked);
    }
}
