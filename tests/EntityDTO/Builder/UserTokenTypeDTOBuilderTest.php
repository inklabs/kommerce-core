<?php
namespace inklabs\kommerce\tests\EntityDTO\Builder;

use inklabs\kommerce\Entity\UserTokenType;

class UserTokenTypeDTOBuilderTest extends AbstractIntegerTypeDTOBuilderTest
{
    /**
     * @return UserTokenType
     */
    protected function getType()
    {
        return $this->dummyData->getUserTokenType();
    }

    public function testExtras()
    {
        $type = $this->getType();

        $typeDTO = $type->getDTOBuilder()
            ->build();

        $this->assertSame($type->isInternal(), $typeDTO->isInternal);
        $this->assertSame($type->isGoogle(), $typeDTO->isGoogle);
        $this->assertSame($type->isFacebook(), $typeDTO->isFacebook);
        $this->assertSame($type->isTwitter(), $typeDTO->isTwitter);
        $this->assertSame($type->isYahoo(), $typeDTO->isYahoo);
    }
}
