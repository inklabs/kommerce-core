<?php
namespace inklabs\kommerce\EntityDTO;

use DateTime;
use inklabs\kommerce\Exception\InvalidArgumentException;
use inklabs\kommerce\tests\Helper\Entity\TestablePromotion;
use inklabs\kommerce\tests\Helper\Entity\TestablePromotionInvalid;
use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

class AbstractPromotionDTOBuilderTest extends EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $promotion = new TestablePromotion;
        $promotion->setStart(new DateTime('2015-01-29'));
        $promotion->setEnd(new DateTime('2015-01-30'));

        $promotionDTO = $promotion->getDTOBuilder()
            ->build();

        $this->assertTrue($promotionDTO instanceof AbstractPromotionDTO);
        $this->assertSame($promotionDTO->startFormatted, '2015-01-29');
        $this->assertSame($promotionDTO->endFormatted, '2015-01-30');
    }

    public function testBuildFails()
    {
        $promotion = new TestablePromotionInvalid;

        $this->setExpectedException(
            InvalidArgumentException::class,
            'promotionDTO has not been initialized'
        );

        $promotion->getDTOBuilder();
    }
}
