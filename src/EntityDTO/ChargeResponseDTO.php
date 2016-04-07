<?php
namespace inklabs\kommerce\EntityDTO;

use DateTime;

class ChargeResponseDTO
{
    /** @var string */
    public $externalId;

    /** @var int */
    public $amount;

    /** @var string */
    public $last4;

    /** @var string */
    public $brand;

    /** @var string */
    public $currency;

    /** @var string */
    public $description;

    /** @var DateTime */
    public $created;
}
