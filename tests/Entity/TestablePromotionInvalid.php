<?php
namespace inklabs\kommerce\tests\Entity;

use inklabs\kommerce\Entity\AbstractPromotion;
use inklabs\kommerce\tests\EntityDTO\TestablePromotionInvalidDTOBuilder;

class TestablePromotionInvalid extends AbstractPromotion
{
    public function getDTOBuilder()
    {
        return new TestablePromotionInvalidDTOBuilder($this);
    }
}
