<?php
namespace inklabs\kommerce\tests\Entity;

use inklabs\kommerce\Entity\AbstractPromotion;
use inklabs\kommerce\tests\EntityDTO\TestablePromotionDTOBuilder;

class TestablePromotion extends AbstractPromotion
{
    /**
     * @return TestablePromotionDTOBuilder
     */
    public function getDTOBuilder()
    {
        return new TestablePromotionDTOBuilder($this);
    }
}
