<?php
namespace inklabs\kommerce\tests\EntityDTO\Builder;

use inklabs\kommerce\Entity\AbstractIntegerType;
use inklabs\kommerce\EntityDTO\AbstractIntegerTypeDTO;
use inklabs\kommerce\EntityDTO\Builder\AbstractIntegerTypeDTOBuilder;
use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

abstract class AbstractIntegerTypeDTOBuilderTest extends EntityDTOBuilderTestCase
{
    /**
     * @return AbstractIntegerType
     */
    abstract protected function getType();

    /**
     * @return AbstractIntegerTypeDTO
     */
    abstract protected function getTypeDTO();

    public function testBuild()
    {
        $type = $this->getType();
        $typeDTO = $this->getTypeDTO();

        $this->assertTrue($typeDTO instanceof AbstractIntegerTypeDTO);
        $this->assertSame($type->getId(), $typeDTO->id);
        $this->assertSame($type->getName(), $typeDTO->name);
        $this->assertSame($type->getNameMap(), $typeDTO->nameMap);
    }
}
