<?php
namespace inklabs\kommerce\EntityDTO;

use DateTime;

class AbstractPromotionDTO
{
    use IdDTOTrait, TimeDTOTrait;

    /** @var string */
    public $name;

    /** @var int */
    public $type;

    /** @var string */
    public $typeText;

    /** @var int */
    public $value;

    /** @var int */
    public $redemptions;

    /** @var int */
    public $maxRedemptions;

    /** @var int */
    public $reducesTaxSubtotal;

    /** @var string */
    public $startFormatted;

    /** @var string */
    public $endFormatted;

    /** @var bool */
    public $isRedemptionCountValid;

    /** @var DateTime */
    public $start;

    /** @var DateTime */
    public $end;
}
