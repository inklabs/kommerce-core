<?php
namespace inklabs\kommerce\tests\EntityDTO\Builder;

use inklabs\kommerce\Entity\UserTokenType;
use inklabs\kommerce\EntityDTO\UserTokenTypeDTO;

class UserTokenTypeDTOBuilderTest extends AbstractIntegerTypeDTOBuilderTest
{
    /**
     * @return UserTokenType
     */
    protected function getType()
    {
        return $this->dummyData->getUserTokenType();
    }

    /**
     * @return UserTokenTypeDTO
     */
    protected function getTypeDTO()
    {
        return $this->getDTOBuilderFactory()
            ->getUserTokenTypeDTOBuilder($this->getType())
            ->build();
    }

    public function testExtras()
    {
        $type = $this->getType();
        $typeDTO = $this->getTypeDTO();

        $this->assertSame($type->isInternal(), $typeDTO->isInternal);
        $this->assertSame($type->isGoogle(), $typeDTO->isGoogle);
        $this->assertSame($type->isFacebook(), $typeDTO->isFacebook);
        $this->assertSame($type->isTwitter(), $typeDTO->isTwitter);
        $this->assertSame($type->isYahoo(), $typeDTO->isYahoo);
    }
}
