<?php
namespace inklabs\kommerce\tests\Entity;

use inklabs\kommerce\Entity\Promotion;
use inklabs\kommerce\tests\EntityDTO\TestablePromotionDTOBuilder;

class TestablePromotion extends Promotion
{
    public function getDTOBuilder()
    {
        return new TestablePromotionDTOBuilder($this);
    }
}
