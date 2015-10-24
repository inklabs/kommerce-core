<?php
namespace inklabs\kommerce\EntityDTO;

use DateTime;

class AbstractPromotionDTO
{
    use IdDTOTrait, TimeDTOTrait;

    public $encodedId;
    public $name;
    public $type;
    public $typeText;
    public $value;
    public $redemptions;
    public $maxRedemptions;
    public $reducesTaxSubtotal;
    public $startFormatted;
    public $endFormatted;
    public $isRedemptionCountValid;

    /** @var DateTime */
    public $start;

    /** @var DateTime */
    public $end;
}
