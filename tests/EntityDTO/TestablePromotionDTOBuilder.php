<?php
namespace inklabs\kommerce\tests\EntityDTO;

use inklabs\kommerce\EntityDTO\Builder\PromotionDTOBuilder;
use inklabs\kommerce\tests\Entity\TestablePromotion;

class TestablePromotionDTOBuilder extends PromotionDTOBuilder
{
    public function __construct(TestablePromotion $testablePromotionInvalid)
    {
        $this->promotionDTO = new TestablePromotionDTO;

        parent::__construct($testablePromotionInvalid);
    }
}
