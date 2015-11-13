<?php
namespace inklabs\kommerce\EntityDTO;

use DateTime;

class ChargeResponseDTO
{
    public $externalId;
    public $amount;
    public $last4;
    public $brand;
    public $currency;
    public $description;

    /** @var DateTime */
    public $created;
}
