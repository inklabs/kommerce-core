<?php
namespace inklabs\kommerce\tests\Entity;

use inklabs\kommerce\Entity\Promotion;
use inklabs\kommerce\tests\EntityDTO\TestablePromotionInvalidDTOBuilder;

class TestablePromotionInvalid extends Promotion
{
    public function getDTOBuilder()
    {
        return new TestablePromotionInvalidDTOBuilder($this);
    }
}
