<?php
namespace inklabs\kommerce\tests\Entity;

use inklabs\kommerce\Entity\AbstractPromotion;
use inklabs\kommerce\tests\EntityDTO\TestablePromotionDTOBuilder;

class TestablePromotion extends AbstractPromotion
{
    public function getDTOBuilder()
    {
        return new TestablePromotionDTOBuilder($this);
    }
}
