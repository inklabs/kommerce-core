<?php
namespace inklabs\kommerce\EntityDTO;

use DateTime;
use inklabs\kommerce\tests\Entity\TestablePromotion;
use inklabs\kommerce\tests\Entity\TestablePromotionInvalid;
use RuntimeException;

class AbstractPromotionDTOBuilderTest extends \PHPUnit_Framework_TestCase
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
            RuntimeException::class,
            'promotionDTO has not been initialized'
        );

        $promotion->getDTOBuilder();
    }
}
