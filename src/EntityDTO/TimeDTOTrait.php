<?php
namespace inklabs\kommerce\EntityDTO;

use DateTime;

trait TimeDTOTrait
{
    /** @var DateTime */
    public $created;

    /** @var DateTime  */
    public $updated;

    /** @var string */
    public $createdFormatted;

    /** @var string  */
    public $updatedFormatted;
}
