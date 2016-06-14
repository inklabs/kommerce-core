<?php
namespace inklabs\kommerce\tests\EntityDTO\Builder;

use inklabs\kommerce\Entity\UserLoginResultType;
use inklabs\kommerce\EntityDTO\UserLoginResultTypeDTO;

class UserLoginResultTypeDTOBuilderTest extends AbstractIntegerTypeDTOBuilderTest
{
    /**
     * @return UserLoginResultType
     */
    protected function getType()
    {
        return $this->dummyData->getUserLoginResultType();
    }

    /**
     * @return UserLoginResultTypeDTO
     */
    protected function getTypeDTO()
    {
        return $this->getDTOBuilderFactory()
            ->getUserLoginResultTypeDTOBuilder($this->getType())
            ->build();
    }

    public function testExtras()
    {
        $type = $this->getType();
        $typeDTO = $this->getTypeDTO();

        $this->assertSame($type->isFail(), $typeDTO->isFail);
        $this->assertSame($type->isSuccess(), $typeDTO->isSuccess);
    }
}
