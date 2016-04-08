<?php
namespace inklabs\kommerce\tests\Helper\Entity;

use inklabs\kommerce\Entity\AbstractPromotion;
use inklabs\kommerce\tests\Helper\EntityDTO\TestablePromotionDTOBuilder;

class TestablePromotion extends AbstractPromotion
{
    /**
     * @return \inklabs\kommerce\tests\Helper\EntityDTO\TestablePromotionDTOBuilder
     */
    public function getDTOBuilder()
    {
        return new TestablePromotionDTOBuilder($this);
    }
}
