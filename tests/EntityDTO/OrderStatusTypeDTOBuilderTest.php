<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\Entity\OrderStatusType;

class OrderStatusTypeDTOBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuild()
    {
        $orderStatusType = OrderStatusType::pending();

        $orderStatusTypeDTO = $orderStatusType->getDTOBuilder()
            ->build();

        $this->assertTrue($orderStatusTypeDTO instanceof OrderStatusTypeDTO);
        $this->assertSame($orderStatusType->getId(), $orderStatusTypeDTO->id);
        $this->assertSame($orderStatusType->getName(), $orderStatusTypeDTO->name);
        $this->assertSame($orderStatusType->getNameMap(), $orderStatusTypeDTO->nameMap);
    }
}
