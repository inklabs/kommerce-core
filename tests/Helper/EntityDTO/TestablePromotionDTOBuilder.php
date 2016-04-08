<?php
namespace inklabs\kommerce\tests\Helper\EntityDTO;

use inklabs\kommerce\EntityDTO\Builder\AbstractPromotionDTOBuilder;
use inklabs\kommerce\tests\Helper\Entity\TestablePromotion;

class TestablePromotionDTOBuilder extends AbstractPromotionDTOBuilder
{
    public function __construct(TestablePromotion $testablePromotion)
    {
        $this->promotionDTO = new TestablePromotionDTO;
        parent::__construct($testablePromotion);
    }
}
