<?php
namespace inklabs\kommerce\tests\EntityDTO;

use inklabs\kommerce\EntityDTO\Builder\AbstractPromotionDTOBuilder;
use inklabs\kommerce\tests\Helper\Entity\TestablePromotionInvalid;

class TestablePromotionInvalidDTOBuilder extends AbstractPromotionDTOBuilder
{
    public function __construct(TestablePromotionInvalid $testablePromotion)
    {
        parent::__construct($testablePromotion);
    }
}
