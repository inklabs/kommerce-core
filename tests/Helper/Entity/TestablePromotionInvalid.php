<?php
namespace inklabs\kommerce\tests\Helper\Entity;

use inklabs\kommerce\Entity\AbstractPromotion;
use inklabs\kommerce\tests\EntityDTO\TestablePromotionInvalidDTOBuilder;

class TestablePromotionInvalid extends AbstractPromotion
{
    /**
     * @return TestablePromotionInvalidDTOBuilder
     */
    public function getDTOBuilder()
    {
        return new TestablePromotionInvalidDTOBuilder($this);
    }
}
