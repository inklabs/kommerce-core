<?php
namespace inklabs\kommerce\EntityDTO;

use DateTime;

class AbstractPromotionDTO
{
    public $id;
    public $encodedId;
    public $name;
    public $type;
    public $typeText;
    public $value;
    public $redemptions;
    public $maxRedemptions;
    public $reducesTaxSubtotal;

    /** @var DateTime */
    public $start;

    /** @var DateTime */
    public $end;

    public $startFormatted;
    public $endFormatted;
    public $created;
    public $updated;

    public $isRedemptionCountValid;
}
