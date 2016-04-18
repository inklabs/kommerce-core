<?php
namespace inklabs\kommerce\EntityDTO;

use DateTime;

class CheckPaymentDTO extends AbstractPaymentDTO
{
    /** @var string */
    public $checkNumber;

    /** @var DateTime */
    public $checkDate;

    /** @var string */
    public $memo;
}
