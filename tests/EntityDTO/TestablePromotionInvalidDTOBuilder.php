<?php
namespace inklabs\kommerce\tests\EntityDTO;

use inklabs\kommerce\EntityDTO\Builder\PromotionDTOBuilder;
use inklabs\kommerce\tests\Entity\TestablePromotionInvalid;

class TestablePromotionInvalidDTOBuilder extends PromotionDTOBuilder
{
    public function __construct(TestablePromotionInvalid $testablePromotionInvalid)
    {
        parent::__construct($testablePromotionInvalid);
    }
}
