<?php
namespace inklabs\kommerce\tests\EntityDTO\Builder;

use inklabs\kommerce\Entity\OrderStatusType;
use inklabs\kommerce\EntityDTO\AbstractIntegerTypeDTO;
use inklabs\kommerce\tests\Helper\DoctrineTestCase;

abstract class AbstractIntegerTypeDTOBuilderTest extends DoctrineTestCase
{
    /**
     * @return OrderStatusType
     */
    abstract protected function getType();

    public function testBuild()
    {
        $type = $this->getType();

        $typeDTO = $type->getDTOBuilder()
            ->build();

        $this->assertTrue($typeDTO instanceof AbstractIntegerTypeDTO);
        $this->assertSame($type->getId(), $typeDTO->id);
        $this->assertSame($type->getName(), $typeDTO->name);
        $this->assertSame($type->getNameMap(), $typeDTO->nameMap);
    }
}
