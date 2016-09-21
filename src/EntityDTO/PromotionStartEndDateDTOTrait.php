<?php
namespace inklabs\kommerce\EntityDTO;

use DateTime;

trait PromotionStartEndDateDTOTrait
{
    /** @var DateTime|null */
    public $start;

    /** @var DateTime|null */
    public $end;

    /** @var string|null */
    public $startFormatted;

    /** @var string|null */
    public $endFormatted;
}
