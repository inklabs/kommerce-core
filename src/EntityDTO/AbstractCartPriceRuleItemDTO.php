<?php
namespace inklabs\kommerce\EntityDTO;

abstract class AbstractCartPriceRuleItemDTO
{
    use IdDTOTrait, TimeDTOTrait;

    /** @var int */
    public $quantity;
}
