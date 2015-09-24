<?php
namespace inklabs\kommerce\tests\EntityDTO;

use inklabs\kommerce\EntityDTO\Builder\AbstractPromotionDTOBuilder;
use inklabs\kommerce\tests\Entity\TestablePromotionInvalid;

class TestablePromotionInvalidDTOBuilder extends AbstractPromotionDTOBuilder
{
    public function __construct(TestablePromotionInvalid $testablePromotionInvalid)
    {
        parent::__construct($testablePromotionInvalid);
    }
}
