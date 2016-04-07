<?php
namespace inklabs\kommerce\EntityDTO;

class TaxRateDTO
{
    use IdDTOTrait, TimeDTOTrait;

    /** @var string */
    public $state;

    /** @var string */
    public $zip5;

    /** @var string */
    public $zip5From;

    /** @var string */
    public $zip5To;

    /** @var double */
    public $rate;

    /** @var bool */
    public $applyToShipping;
}
